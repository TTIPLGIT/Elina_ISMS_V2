<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\File;
use PDF;
use DB;
use Illuminate\Support\Carbon;

class SaildocumentController extends BaseController
{

    public function index(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => SaildocumentController => index';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/sail/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];
        $submitted = $response_data['submitted'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('sail.index', compact('user_id', 'rows', 'submitted', 'modules', 'screens'));
        //
    }

    public function sailstatus(Request $request)
    {

        $user_id = $request->session()->get("userID");

        $method = 'Method => SaildocumentController => index';

        $gatewayURL = config('setting.api_gateway_url') . '/sail/sailstatus';
        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];
        $actions = $response_data['actions'];
        $count = count($rows);
        for ($i = 0; $i < $count; $i++) {
            $rows[$i]['is_coordinator1'] = json_decode($rows[$i]['is_coordinator1'], true);
            $rows[$i]['is_coordinator2'] = json_decode($rows[$i]['is_coordinator2'], true);
        }
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        return view('sail.sailstatus', compact('screen_permission', 'actions', 'user_id', 'rows', 'modules', 'screens'));
        //
    }

    public function questionnaireinitiate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => SaildocumentController => questionnaireinitiate';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/sail/questionnaireinitiate';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];
        $paymenttokentime = $response_data['paymenttokentime']; //dd($paymenttokentime[0]['token_expire_time']);

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('sail.questionnaireinitiate', compact('paymenttokentime', 'user_id', 'rows', 'modules', 'screens'));
    }
    public function sailquestionnaireinitiate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => SaildocumentController => sailquestionnaireinitiate';
        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/sail/sailquestionnaireinitiate';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];
        $activity = $response_data['activity'];
        $paymenttokentime = $response_data['paymenttokentime'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('sail.sailquestionnaireinitiate', compact('paymenttokentime', 'user_id', 'rows', 'modules', 'screens', 'activity'));
    }
    public function questionnaireindex(Request $request)
    {

        $user_id = $request->session()->get("userID");
        $method = 'Method => SaildocumentController => index';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/sail/sailquestionnairelistview';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];

        // $submitted = $response_data['submitted'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('sail.saillistview', compact('user_id', 'rows', 'modules', 'screens'));
        //
    }
    public function store(Request $request)
    {

        try {
            $method = 'Method => SaildocumentController => store';
            $state = $request->btn_status;
            $method = 'Method => SaildocumentController => store';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['status'] = $request->status;
            $data['questionnaire_id'] = $request->questionnaire_id;
            $data['type'] = $request->btn_status;
            $data['initiatedTo'] = $request->userID;
            $data['stage'] = $request->stage;
            $stage = $request->stage;
            // $paymenttokentime = $request->paymenttokentime;
            // $paymenttokentime = (int)$paymenttokentime;
            // $udata['id'] = $request->userID;
            // $udata['ids'] = 'pay';
            // $udataArray = $this->encryptData($udata);
            // // dd($udataArray);
            // $url = URL::temporarySignedRoute(
            //     'signed.questionnaire',
            //     now()->addMinutes($paymenttokentime),
            //     [
            //         'id' => $request->userID,
            //         'hash' => 'pay',
            //     ]
            // );dd($url);
            // $data['url'] = $url;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    if ($state == 'Sent') {
                        $this->CreatSignedURL($parant_data);
                        if ($stage == 'ovm') {
                            return redirect(route('ovm.questionnaire'))->with('success', 'Parent Feedback Form Initiated Successfully');
                        } else {
                            return redirect(route('sailquestionnairelistview'))->with('success', 'SAIL questionnaire initiated successfully');
                        }

                        // return redirect(route('ovm.questionnaire'))->with('success', 'SAIL questionnaire initiated successfully');
                    }

                    return redirect(route('ovm.questionnaire'))->with('success', 'Questionnaire Initiation Saved Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm.questionnaire'))->with('error', 'Questionnaire Already Initiated');
                }
                if ($objData->Code == 401) {
                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function sail_store(Request $request)
    {

        try {
            $method = 'Method => SaildocumentController => sail_store';


            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $state = $request->btn_status;

            $method = 'Method => SaildocumentController => sail_store';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['status'] = $request->status;
            $data['questionnaire_id'] = $request->questionnaire_id;
            $data['type'] = $request->btn_status;
            $data['initiatedTo'] = $request->userID;
            $data['activity_id'] = $request->activity_id;
            $data['activity_discription'] = $request->activity_discription;
            $stage = $request->stage;

            // $paymenttokentime = $request->paymenttokentime;
            // $paymenttokentime = (int)$paymenttokentime;
            // $udata['id'] = $request->userID;
            // $udata['ids'] = 'pay';
            // $udataArray = $this->encryptData($udata);
            // // dd($udataArray);
            // $url = URL::temporarySignedRoute(
            //     'signed.questionnaire',
            //     now()->addMinutes($paymenttokentime),
            //     ['id' => $udataArray]
            // );dd($url);
            // $data['url'] = $url;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/sailstoredata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    if ($state == 'Sent') {
                        $this->CreatSignedURL($parant_data);
                        if ($stage == 'ovm') {
                            return redirect(route('ovm.questionnaire'))->with('success', 'Parent Feedback Form Initiated Successfully');
                        } else {
                            return redirect(route('sailquestionnairelistview'))->with('success', 'SAIL questionnaire initiated successfully');
                        }

                        // return redirect(route('ovm.questionnaire'))->with('success', 'SAIL questionnaire initiated successfully');
                    }

                    return redirect(route('ovm.questionnaire'))->with('success', 'Questionnaire Initiation Saved Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm.questionnaire'))->with('error', 'Questionnaire Already Initiated');
                }
                if ($objData->Code == 401) {
                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function show($id)
    {
        try {
            $method = 'Method => SaildocumentController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/data_edit/' . $id;

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
                    return view('sail.show', compact('rows', 'screens', 'modules'));
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

    public function edit($id)
    {


        try {
            $method = 'Method => SaildocumentController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/sail/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];

                    // $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    // $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('sail.edit', compact('rows', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $method = 'Method =>  SaildocumentController => update_data';
            $data = array();
            $data['id'] = $this->decryptData($id);
            $data['status'] = $request->btn_status;
            $data['questionnaire_id'] = $request->questionnaire_id;
            $data['user_id'] = $request->user_id;


            // $data['meeting_status'] =  ($request->type =='sent')?$request->type:$request->meeting_status;




            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/updatedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $this->CreatSignedURL($parant_data);
                    return redirect(route('sail.index'))
                        ->with('success', 'SAIL questionnaire initiated successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Questionnaire Already Initiated');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
// dd($this->decryptData($id));
            $method = 'Method => SaildocumentController => delete';

            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/sail/data_delete/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('sail.index'))
                        ->with('success', 'Questionnaire initiation Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('sail.index'))
                        ->with('fail', 'questionnaire initiation Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function GetAllDepartmentsByDirectorate(Request $request)

    {
        $method = 'Method => SaildocumentController => GetAllDepartmentsByDirectorate';
        try {

            $enrollment_id = $request->enrollment_id;



            $request = array();

            $request['requestData'] = $enrollment_id;

            $gatewayURL = config('setting.api_gateway_url') . '/sail/getchildenrollment';
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
    public function SignedQuestionnaire(Request $request,  $id)
    {
        try {
            $method = 'Method => SaildocumentController => ParentFeedbackForm';

            // $ids = $this->DecryptData($id); dd($ids);
            $input = [
                'id' => $id,
            ];

            $questionnaireID = $request->questionnaireID;
            $gatewayURL = config('setting.api_gateway_url') . '/signedLogin';
            $encryptArray = $this->encryptData($input);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response1);

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
            }
            $QID = $questionnaireID; //$this->WriteFileLog($QID);
            $questionnaireID = $this->encryptData($QID); //$this->WriteFileLog($questionnaireID);
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_for_parents/editdata/' . $questionnaireID;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response); //dd($response);

            // $questionnaire_initiation_id = $this->decryptData($questionnaireID);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $question_details =  $parant_data['question_details'];
                    $question = $parant_data['question'];
                    $currentstatus = $parant_data['view'];
                    $submit_status = $parant_data['submit_status'];
                    $fieldOptionsDB = $parant_data['fieldOptions'];
                    $fieldQuestionsDB = $parant_data['fieldQuestions'];
                    $questionDetails = $parant_data['questionDetails'];
                    $options = $parant_data['options'];
                    $role = $parant_data['role'];
                    $questionnaire_initiation_id = $questionnaire_initiation_id = $this->decryptData($questionnaireID);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($currentstatus == 'new') {
                        return view('questionnaire_for_parents.fill_form', compact('role', 'options', 'questionDetails', 'fieldQuestionsDB', 'fieldOptionsDB', 'currentstatus', 'questionnaire_initiation_id', 'screens', 'modules', 'question_details', 'question'));
                    } elseif ($currentstatus == 'update') {
                        if ($submit_status == 'save') {
                            return view('questionnaire_for_parents.edit_form', compact('role', 'options', 'questionDetails', 'fieldQuestionsDB', 'fieldOptionsDB', 'currentstatus', 'questionnaire_initiation_id', 'screens', 'modules', 'question_details', 'question'));
                        } elseif ($submit_status == 'submit') {
                            return redirect()->route('questionnaire.submitted.form', $questionnaireID);
                            // return view('questionnaire_for_parents.edit_form', compact('currentstatus', 'questionnaire_initiation_id', 'screens', 'modules', 'question_details', 'question'));
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

    public function CreatSignedURL($data)
    {
        try {
            $method = 'Method => SaildocumentController => CreatSignedURL';

            $gatewayURL = config('setting.api_gateway_url') . '/signed/form/url';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $tokentime =  $parant_data['tokentime'];
                    $tokentime = (int)$tokentime[0]['token_expire_time'];
                    $udata['id'] = $data['initiatedTo'];
                    $udata['questionnaireID'] = $data['questionnaireID'];
                    $udataArray = $this->encryptData($udata);
                    // dd($udataArray);
                    $urlArray = array();
                    $queArray = array();
                    $qDesId = $data['questionnaireID'];
                    $urlcount = count($qDesId);

                    for ($i = 0; $i < $urlcount; $i++) {
                        $url = URL::temporarySignedRoute(
                            'signed.questionnaire',
                            now()->addMinutes($tokentime),
                            [
                                'id' => $data['initiatedTo'],
                                'questionnaireID' => $qDesId[$i],
                            ]
                        );
                        $urlArray[$i] = $url;
                        $queArray[$i] = $qDesId[$i];
                    }

                    // $this->WriteFileLog($urlArray);
                    $SendData = array();
                    $SendData['url'] = $urlArray;
                    $SendData['id'] = $data['initiatedTo'];
                    $SendData['questionnaireID'] = $data['questionnaireID'];
                    $SendData['queArray'] = $queArray;
                    // $encData = $this->encryptData($SendData);//dd($encData);
                    $method = 'Method => SaildocumentController => CreatSignedURL';

                    $request1 = array();
                    $request1['requestData'] = $SendData;
                    $gatewayURL1 = config('setting.api_gateway_url') . '/signed/form/email';

                    $response1 = $this->serviceRequest($gatewayURL1, 'POST', json_encode($request1), $method);
                    $response1 = json_decode($response1);
                    if ($response1->Status == 200 && $response1->Success) {
                        return true;
                    } else {
                        $objData1 = json_decode($this->decryptData($response1->Data));
                        echo json_encode($objData1->Code);
                        exit;
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

    public function SailInitiate(Request $request)
    {
        try {

            $method = 'Method => SaildocumentController => SailInitiate';

            $gatewayURL = config('setting.api_gateway_url') . '/sail/initiate';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $response_data = json_decode(json_encode($objData->Data), true);
            $rows = $response_data['rows'];
            $iscoordinators = $response_data['iscoordinators'];

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('sail.SailInitiate', compact('iscoordinators', 'rows', 'modules', 'screens'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function SailInitiateStore(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => SailInitiateStore';

            $folderPath = $request->child_id;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/sail_consent/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/sail_consent/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath);
                    }
                }
            }


            $documentName = 'consent_form_sail.pdf';
            $output = $storagePath . '/' . $documentName;
            $consentdata = [
                'childName' => $request->child_name,
                'payableAmount' => $request->payableAmount,
            ];
            $pdf = PDF::loadView('pdfTemplates.consentform_Sail', compact('consentdata'));
            $pdf->save($output);

            // dd($output);
            $data = array();

            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['user_id'] = $request->user_id;
            $data['consent_form'] = $output;
            $data['notification'] = 'sail_consent/' . $folderPath . '/' . $documentName;

            // dd($data);
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/initiate/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // dd($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {

                    $this->SailFeeInitiate($objData->Data);
                    return redirect(route('sailstatus'))->with('success', 'Sail Initiated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('sailstatus'))->with('fail', 'Sail Already Initiated');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function SailReInitiateStore(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => SailReInitiateStore';

            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['user_id'] = $request->user_id;
            // dd($data);
            $url = URL::signedRoute('signed.sail.initiate', ['user_id' => $this->encryptData($request->user_id)]);
            $data['url'] = $url;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/reinitiate/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // dd($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('sailstatus'))->with('success', 'Sail Reinitiated Successfully');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function SailFeeInitiate($request)
    {
        try {
            $method = 'Method => UserregisterfeeController => store_data';
            //sail invoice

            $child_name = $request->child_name;
            $payment_amount = $request->payment_amount;



            $folderPath = $request->initiated_to;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/sail_invoice_document/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/sail_invoice_document/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath);
                    }
                }
            }


            $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
            $document_name = 'PAYMENT_INVOICE_RECEIPT';
            $input = base_path() . '/reports/PAYMENT_INVOICE_RECEIPT.jasper';


            //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            $output = $storagePath . '/' . $documentName;
            $output_1 = $storagePath . '/' . $document_name;
            $storagePath = public_path() . '/sail_invoice_document/';
            $report_path = public_path() . '/sail_invoice_document/' . $folderPath;


            $options = [
                'format' => ['pdf'],
                'locale' => 'en',
                'params' => [
                    'child_name' =>  $child_name,
                    'payment_amount' => $payment_amount,
                    'child_id' => $request->child_id,

                ],


                'db_connection' => [
                    'driver' => 'mysql',
                    'username' => config('setting.db_username'),
                    'password' => config('setting.db_password'),
                    'host' => '127.0.0.1',
                    'database' => config('setting.db_database'),
                    'port' => config('setting.db_port'),
                ]
            ];
            $jasper = new PHPJasper;
            //echo json_encode($output); exit;
            //  echo json_encode($options); exit;
            $jasper->process(
                $input,
                $output_1,
                $options
            )->execute();

            $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
            $headers = array(
                'Content-Type: application/pdf',
            );
            //End sail invoice

            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;

            $data['initiated_by'] = $request->initiated_by;
            $data['initiated_to'] = $request->initiated_to;
            $data['payment_amount'] = $request->payment_amount;
            $data['payment_status'] = $request->payment_status;
            $data['payment_process_description'] = $request->payment_process_description;
            $data['payment_for'] = $request->payment_for;
            $data['user_id'] = $request->user_id;
            $data['sail_invoice'] = $output;
            $paymenttokentime = (int)$request->paymenttokentime;

            $url = URL::temporarySignedRoute(
                'payuserfees.create1',
                now()->addMinutes($paymenttokentime),
                ['id' => encrypt($request->user_id)]
            );
            $data['url'] = $url;
            // $data['transaction_id'] = $request->transaction_id;
            // $data['receipt_num'] = $request->receipt_num;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/store_data';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))
                        ->with('success', 'Initiated Successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Already Initiated');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function edit_data($id)
    {
        // dd($this->DecryptData($id));

        try {
            $method = 'Method => SaildocumentController => edit_data';

            $gatewayURL = config('setting.api_gateway_url') . '/sail/edit_data/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $iscoordinators = $parant_data['iscoordinators'];
                    $rows = $parant_data['rows'];
                    $questionnaire = $parant_data['questionnaire'];
                    $video = $parant_data['video'];
                    $payment = $parant_data['payment'];
                    // dd($rows);
                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    if ($rows[0]['is_coordinator2'] != null) {
                        $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    }

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('sail.sailstatusedit', compact('iscoordinators', 'payment', 'rows', 'video', 'questionnaire', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function sail_complete(Request $request, $id)
    {
        try {
            $method = 'Method => ovm1Controller => store';
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['user_id'] = $request->user_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['payment_status'] = $request->payment_status;
            $data['current_status'] = $request->action_btn;
            $data['is_1'] = $request->is_1;
            $data['is_2'] = $request->is_2;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sailcomplete/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return redirect(route('sailstatus'))->with('success', 'Sail Status Submitted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovmmeetingcompleted'))->with('fail', 'Sail Status Already Completed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function signedLoginSub(Request $request)
    {
        try {
            $method = 'Method => Paymentcontroller => create';
            $ids = $this->DecryptData($request->user_id);
            $input = [
                'id' => $ids,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/signedLoginSub';
            $encryptArray = $this->encryptData($input);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response1);

            if ($response->Status == 401) {
                return back()->withErrors(['recaptcha' => ['Invalid User']]);
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
                $ResponseData = $objData->ResponseData;
            }

            $folderPath = $ResponseData->child_id;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/sail_consent/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/sail_consent/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath);
                    }
                }
            }

            $documentName = 'consent_form_sail.pdf';
            $output = $storagePath . '/' . $documentName;
            // $consentdata = [
            //     'childName' => $ResponseData->child_name,
            //     'payableAmount' => $ResponseData->payableAmount,
            // ];
            // // dd($consentdata);
            // $pdf = PDF::loadView('pdfTemplates.consentform_Sail', compact('consentdata'));

            $policyContent = DB::table('policy_publish')->where('id', 5)->value('policy_content');
            $payableAmount = $ResponseData->payableAmount;
            $parentName = $ResponseData->childGuardianName;
            $sailDate = Carbon::now()->format('d-m-Y');
            $consentData1 = str_replace(
                ['%SAIL_FEE%', '%SAIL_PARENT_NAME%', '%SAIL_DATE%'], 
                [$payableAmount, $parentName, $sailDate],            
                $policyContent
            );
            $pdf = PDF::loadView('pdfTemplates.SAIL_Consent', compact('consentData1'));

            $pdf->save($output);
            // dd($output);

            $data = array();
            $data['enrollment_child_num'] = $ResponseData->enrollment_child_num;
            $data['enrollment_id'] = $ResponseData->enrollment_id;
            $data['child_id'] = $ResponseData->child_id;
            $data['child_name'] = $ResponseData->child_name;
            $data['is_coordinator1'] = $ResponseData->is_coordinator1;
            $data['is_coordinator2'] = $ResponseData->is_coordinator2;
            $data['user_id'] = $ResponseData->user_id;
            $data['consent_form'] = $output;
            $data['notification'] = 'sail_consent/' . $folderPath . '/' . $documentName;

            // dd($data);
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/initiate/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // dd($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    // dd($objData->Data);
                    // return redirect(route('sail.consent'));
                    $vData = $objData->Data;
                    $consent_aggrement = $objData->consent_aggrement;
                    if($consent_aggrement == 'Declined'){
                        return redirect(route('newenrollment.show', $this->encryptData($vData->enrollment_id)))->with('success', 'Your SAIL Process has been Already Submitted.');
                    }
                    if ($consent_aggrement != 'Agreed') {
                        return redirect(route('sail.consent', $this->encryptData($vData->enrollment_child_num)));
                    } else {
                        return redirect(route('newenrollment.show', $this->encryptData($vData->enrollment_id)))->with('success', 'Your SAIL Process has been Initiated');
                    }
                    // $this->sail_consent($objData->Data);
                    // $this->SailFeeInitiate($objData->Data);
                    // return redirect(route('payuserfee.index'))->with('success', 'Sail Initiated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('sailstatus'))->with('fail', 'Sail Already Initiated');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function submitDenial(Request $request, $id)
    {
        // dd($request, $this->decryptData($id));
        try {
            $method = 'Method => UserController => submitDenial';
            $ids = $this->DecryptData($id);
            $input = [
                'id' => $ids,
            ];
            $gatewayURL = config('setting.api_gateway_url') . '/signedLoginSail';
            $encryptArray = $this->encryptData($input);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response1);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $row = json_decode(json_encode($objData), true);
                session(['accessToken' => $row['access_token']]);
                session(['userType' => $row['user']['user_type']]);
                session(['userID' => $row['user']['id']]);
                session(['sessionTimer' => $objData->formattedDateTime]);
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $data = $row['ResponseData'];
                $details = $row['ResponseDetails'];
                if (empty($details)) {
                    return view('sail.sail_decline', compact('screens', 'modules', 'data'));
                }
                if ($details[0]['consent_aggrement'] == 'Agreed') {
                    return redirect(route('newenrollment.show', $this->encryptData($data[0]['enrollment_id'])))->with('success', 'You have Already agreed to the SAIL Program');
                }
                if ($details[0]['consent_aggrement'] != 'Agreed' && $details[0]['current_status'] != "Sail Reinitiated") {
                    return redirect(route('newenrollment.show', $this->encryptData($data[0]['enrollment_id'])))->with('fail', 'Your SAIL Response Already Submitted');
                    // return redirect(route('newenrollment.index'))->with('error', 'Your SAIL Response Already Submitted');

                } else {
                    return view('sail.sail_decline', compact('screens', 'modules', 'data'));
                }
            } else {
                return redirect(route('/'))->with('fail', 'Token Expired');
            }
            // 

            // $data = array();
            // $data['denialOption'] = $request->denialOption;
            // $data['weekSelect'] = $request->weekSelect;
            // $data['userID'] = $this->decryptData($id);
            // $encryptArray = $this->encryptData($data);
            // $request = array();
            // $request['requestData'] = $encryptArray;
            // $gatewayURL = config('setting.api_gateway_url') . '/submitDenial';
            // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // $response1 = json_decode($response);
            // $objData = json_decode($this->decryptData($response1->Data));
            // echo $this->decryptData($response1->Data);
            return redirect(route('/'))->with('success', 'Your SAIL Response Submitted Successfully');
            // dd($objData);

        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function SailConsentDenail(Request $request)
    {
        try {
            $method = 'Method => UserController => SailConsentDenail';

            $data = array();
            $data['denialOption'] = $request->confirmation;
            $data['weekSelect'] = $request->weekSelect;
            $data['userID'] = $request->user_id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/submitDenial';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            if ($objData->Code == 200) {
                return redirect(route('newenrollment.show', $this->encryptData($objData->Data)))->with('success', 'Your have Declined to the SAIL Process');
                // return redirect(route('newenrollment.index'))->with('success', 'Your SAIL Response Submitted Successfully');
            } else {
                return redirect(route('newenrollment.show', $this->encryptData($objData->Data)))->with('error', 'Your SAIL Response Already Submitted');
                // return redirect(route('newenrollment.index'))->with('error', 'Your SAIL Response Already Submitted');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function sail_consent(Request $request, $id)
    {
        try {
            $method = 'Method => OVMAllocationController => sail_consent';

            $gatewayURL = config('setting.api_gateway_url') . '/sail/consent/form';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($id), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // dd($parant_data);
                    $data = $parant_data['data'];
                    $consentData = $parant_data['consentData'];
                    $answered = $parant_data['agreed'];
                    
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    if ($answered != []) {
                        return redirect(route('newenrollment.show', $this->encryptData($data['enrollmentID'])))->with('fail', 'Your SAIL Response Already Submitted');
                    } else {
                        return view('sail.consent_form', compact('screens', 'modules', 'data', 'consentData'));
                    }
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function SailConsentAccept(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method => UserregisterfeeController => SailConsentAccept';
            $btn_status = $request->btn_status;
            if ($btn_status == 'Declined') {
                // dd('Declined');
                $enrollmentID = $request->enrollmentID;
                $data = array();
                $data['enrollment_child_num'] = $request->enrollment_child_num;
                $data['child_id'] = $request->child_id;
                $data['child_name'] = $request->child_name;
                $data['initiated_to'] = $request->initiated_to;
                $data['user_id'] = $request->user_id;
                $data['consent_aggrement'] = $request->btn_status;
                // dd($data);
                $encryptArray = $this->encryptData($data);

                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/sail/consent/declined';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('newenrollment.show', $this->encryptData($enrollmentID)))->with('success', 'Your have Declined to the SAIL Process');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } else {
                // dd('Accepted');
                //sail invoice
                $child_name = $request->child_name;
                $payment_amount = $request->payment_amount;
                $folderPath = $request->initiated_to;
                $parentname = $request->parentname;
                //$folderPath = str_replace(' ', '-', $folderPath);
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/sail_invoice_document/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/sail_invoice_document/';

                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;

                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }


                $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
                $document_name = 'PAYMENT_INVOICE_RECEIPT';
                $input = base_path() . '/reports/PAYMENT_INVOICE_RECEIPT.jasper';


                $output = $storagePath . '/' . $documentName;
                $output_1 = $storagePath . '/' . $document_name;
                $storagePath = public_path() . '/sail_invoice_document/';
                $report_path = public_path() . '/sail_invoice_document/' . $folderPath;

                $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
                $headers = array(
                    'Content-Type: application/pdf',
                );
                //End sail invoice
                $users = DB::table('payment_status_details')->select('payment_status_id')->orderBy('payment_status_id', 'DESC')->first();
                if (empty($users)) {
                    $invoice = 1;
                } else {
                    $invoice = $users->payment_status_id + 1;
                }
                $amount_text = $this->numberToWords($payment_amount);
                $decMasterData = $this->decryptData($request->masterData);
                $data = [
                    'father_name' => $parentname,
                    'child_name' => $child_name,
                    'register_fee' => $payment_amount,
                    'in_words' => $amount_text,
                    'id' => $invoice,
                    'serviceList' =>  $decMasterData['serviceList'],
                    'baseAmount' => $request->baseAmount,
                    'gstAmount' => $request->gstAmount
                ];
                $pdf = PDF::loadView('pdfTemplates.sail_invoice', compact('data'));
                $pdf->save($output);

                $data = array();
                $data['enrollment_child_num'] = $request->enrollment_child_num;
                $data['child_id'] = $request->child_id;
                $data['child_name'] = $request->child_name;

                $data['initiated_by'] = $request->initiated_by;
                $data['initiated_to'] = $request->initiated_to;
                $data['payment_amount'] = $request->payment_amount;
                $data['payment_status'] = $request->payment_status;
                $data['payment_process_description'] = $request->payment_process_description;
                $data['payment_for'] = $request->payment_for;
                $data['user_id'] = $request->user_id;
                $data['sail_invoice'] = $output;
                $data['consent_aggrement'] = $request->consent_aggrement;
                $paymenttokentime = (int)$request->paymenttokentime;

                $url = URL::temporarySignedRoute(
                    'payuserfees.create1',
                    now()->addMinutes($paymenttokentime),
                    ['id' => encrypt($request->user_id)]
                );
                $data['url'] = $url;
                // $data['transaction_id'] = $request->transaction_id;
                // $data['receipt_num'] = $request->receipt_num;
                $encryptArray = $this->encryptData($data);

                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/store_data';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('payuserfee.create'))->with('success', 'Consent Form Submitted and Payment Initiated Successfully');
                    }

                    if ($objData->Code == 400) {
                        return Redirect::back()->with('fail', 'Already Initiated');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function referral_request(Request $request, $id)
    {
        // dd($request, $this->decryptData($id));

        $action = $request->action;
        $data = array();
        $data['user_id'] = $this->decryptData($id);
        $data['action'] = $request->action;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $method = 'Method => Paymentcontroller => referral_request';
        $gatewayURL = config('setting.api_gateway_url') . '/referal/accept/' . $id;
        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        $response = json_decode($response);
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($action == 'Accept') {
                return redirect(route('/'))->with('success', 'Thank you for the reply.The Referral Report will soon be sent to your mailbox');
            } else {
                return redirect(route('/'))->with('success', 'Your response has been sent successfully');
            }
        } else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
}
