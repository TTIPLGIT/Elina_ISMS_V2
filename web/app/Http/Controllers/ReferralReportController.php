<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PDF;

class ReferralReportController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $method = 'Method => ReferralReportController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    // dd($rows);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];

                    return view('referral_report.index', compact('modules', 'screens', 'screen_permission', 'rows'));
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

    public function create(Request $request)
    {

        try {
            $method = 'Method => ReferralReportController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $recommendations = $parant_data['recommendations'];
                    $enrollment_details = $parant_data['enrollment_details'];
                    $specialization = $parant_data['specialization'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('referral_report.create', compact('specialization', 'enrollment_details', 'recommendations', 'screens', 'modules'));
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

    public function store(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method => ReferralReportController => store';

            $currentPage = $request->currentPage;
            $data = array();
            $data['dor'] = $request->dor;
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['focus_area'] = $request->focus_area;
            $data['referral_users'] = $request->referral_users;
            $data['frequency'] = $request->frequency;
            $data['recommendation_area'] = $request->recommendation_area;
            $data['referral_users_other'] = $request->referral_users_other;
            $data['focus_area_other'] = $request->focus_area_other;
            $data['signature'] = $request->signature;
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $rId = $objData->Data;
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // return redirect(route('referralreport.index'));
                    if ($objData->check == 0) {
                        // $this->assessment_report($objData->enrollmentId, $objData->reports_id);
                        return redirect(route('referral.report.render', $this->encryptData($objData->reports_id)))->with('success', 'The Referral Report has been submitted successfully.');
                    }
                    // return redirect(url()->previous());
                    return redirect(route('referralreport.edit', $this->encryptData($objData->reports_id)))->with('page', $currentPage)->with('success', 'The The Referral Report saved successfully..');
                }


                if ($objData->Code == 400) {
                    return Redirect(route('reports_master.index'))
                        ->with('fail', 'Page Already Exists');
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

    public function GetUser(Request $request)
    {
        $method = 'Method => ReferralReportController => GetUser';
        try {
            $focus_area = $request->focus_area;
            $request = array();
            $request['requestData'] = $focus_area;
            $gatewayURL = config('setting.api_gateway_url') . '/therapist/specialization/getuser';
            $serviceResponse = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
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

    public function edit($id)
    {
        try {
            $method = 'Method => NewenrollementController => edit';
            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report'];
                    // dd($report);
                    $recommendations = $parant_data['recommendations'];
                    $specialization = $parant_data['specialization'];
                    $serviceProviders = $parant_data['serviceProviders'];
                    $rowSpan = $parant_data['rowSpan'];
                    $signature = json_decode($report[0]['signature'], true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('referral_report.edit', compact('signature','screens', 'modules', 'report', 'recommendations', 'specialization', 'serviceProviders', 'rowSpan'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }

        //

    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request);
            $method = 'Method => ReferralReportController => store';

            $currentPage = $request->currentPage;
            $data = array();
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['focus_area'] = $request->focus_area;
            $data['referral_users'] = $request->referral_users;
            $data['frequency'] = $request->frequency;
            $data['recommendation_area'] = $request->recommendation_area;
            $data['report_id'] = $this->decryptData($id);
            $data['referral_users_other'] = $request->referral_users_other;
            $data['focus_area_other'] = $request->focus_area_other;
            $data['signature'] = $request->signature;
            $data['dor'] = $request->dor;
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $rId = $objData->Data;
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // return redirect(route('referralreport.index'));
                    if ($objData->check == 0) {
                        // $this->assessment_report($objData->enrollmentId, $objData->reports_id);
                        return redirect(route('referral.report.render', $this->encryptData($objData->reports_id)))->with('success', 'The Referral Report has been submitted successfully.');
                    }
                    // return redirect(url()->previous());
                    return redirect(route('referralreport.edit', $this->encryptData($objData->reports_id)))->with('page', $currentPage)->with('success', 'The Referral Report saved successfully.');
                }


                if ($objData->Code == 400) {
                    return Redirect(route('reports_master.index'))
                        ->with('fail', 'Page Already Exists');
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

    public function show(Request $request, $id)
    {
        try {
            $method = 'Method => NewenrollementController => edit';
            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report'];
                    // dd($report);
                    $recommendations = $parant_data['recommendations'];
                    $specialization = $parant_data['specialization'];
                    $serviceProviders = $parant_data['serviceProviders'];
                    $rowSpan = $parant_data['rowSpan'];
                    $signature = json_decode($report[0]['signature'], true);
                    // PDF
                    $folderPath =  $report[0]['child_contact_email'];

                    //$folderPath = str_replace(' ', '-', $folderPath);
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/referral_report/' . $folderPath;
            
            
                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/referral_report/';
            
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
            
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }
                    $email = $parant_data['email'];
                    // $this->WriteFileLog($request->entirePage);
                    $data = [
                        // 'reportID' => $request->reportID,
                        // 'data' => $request->entirePage,
                        'childName' => $request->childName
                    ];
                    $data = [
                        'report_id' => $report[0]['report_id'],
                        'enrollment_id' => $report[0]['enrollment_id'],
                        'child_name' => $report[0]['child_name'],
                        'child_dob' => $report[0]['child_dob'],
                        'dor' => $report[0]['dor'],
                        'signature' => $signature,
                        'email' => $report[0]['child_contact_email'],
                        'email_draft' => $email,
                        'status'=>$report[0]['status'],
                    ];
                    // dd('sdds');
                    // $pdf = PDF::loadView('referral_report.referralPDF', compact('data','report', 'recommendations', 'specialization', 'serviceProviders', 'rowSpan'))->setPaper('a4', 'landscape');
                    // $pdf->save($storagePath . '/referral_report.pdf');
                    // dd($storagePath . '/referral_report.pdf');
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $viewPDF = '/referral_report/' . $folderPath . '/referral_report.pdf';
                    return view('referral_report.PDFpreview', compact('screens', 'modules','viewPDF','report','data'));
                    // return view('referral_report.preview', compact('screens', 'modules', 'report', 'recommendations', 'specialization', 'serviceProviders', 'rowSpan'));
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

    public function ReferralPreview(Request $request, $id)
    {
        try {
            $method = 'Method => NewenrollementController => render';
            if ($request->isMethod('post')) {
                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/referral_report/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/referral_report/';
        
                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;
        
                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }
                $htmlContent = $request->input('report');
                $data = $this->decryptData($request->data);
                // dd($htmlContent , $data);
                // $pdf = PDF::loadView('recommendation.RecommendationRender', compact('htmlContent'))->setPaper('legal', 'landscape');
                // dd($data);
                $pdf = PDF::loadView('referral_report.referralPDF', compact('htmlContent'))->setPaper('a4', 'landscape');
                $pdf->save($storagePath . '/referral_report.pdf');
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $viewPDF = '/referral_report/' . $folderPath . '/referral_report.pdf';
                return view('referral_report.PDFpreview', compact( 'data', 'screens', 'modules', 'viewPDF'));
            }
            $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report'];
                    $signature = json_decode($report[0]['signature'], true);
                    // dd($report);
                    $recommendations = $parant_data['recommendations'];
                    $specialization = $parant_data['specialization'];
                    $serviceProviders = $parant_data['serviceProviders'];
                    $rowSpan = $parant_data['rowSpan'];
                    $email = $parant_data['email'];
                    // PDF
            
            
                //   dd($request->entirePage);
                    // $this->WriteFileLog($request->entirePage);
                    $data = [
                        // 'reportID' => $request->reportID,
                        // 'data' => $request->entirePage,
                        'childName' => $request->childName
                    ];
                    $Mdata = [
                        'report_id' => $report[0]['report_id'],
                        'enrollment_id' => $report[0]['enrollment_id'],
                        'child_name' => $report[0]['child_name'],
                        'child_dob' => $report[0]['child_dob'],
                        'dor' => $report[0]['dor'],
                        'signature' => $signature,
                        'email' => $report[0]['child_contact_email'],
                        'email_draft' => $email,
                        'status' => $report[0]['status'],
                    ];
                    // dd($data['email']);
                   
                    // dd($storagePath . '/referral_report.pdf');
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    // $viewPDF = '/referral_report/' . $folderPath . '/referral_report.pdf';
                    return view('referral_report.ReferralReport', compact('screens', 'modules','Mdata','report', 'recommendations', 'specialization', 'serviceProviders', 'rowSpan'));
                    // return view('referral_report.preview', compact('screens', 'modules', 'report', 'recommendations', 'specialization', 'serviceProviders', 'rowSpan'));
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

    public function generatePDF(Request $request)
    {
        $method = 'Method => assessmentreportController => Recommendation_report';
        // dd($request->child_contact_email);
        $folderPath = $request->child_contact_email;

        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/referral_report/' . $folderPath;


        // if (!File::exists($storagePath)) {
        //     $storagePath = public_path() . '/referral_report/';

        //     $arrFolder = explode('/', $folderPath);
        //     foreach ($arrFolder as $key => $value) {
        //         $storagePath .= '/' . $value;

        //         if (!File::exists($storagePath)) {
        //             File::makeDirectory($storagePath);
        //         }
        //     }
        // }
        // // $this->WriteFileLog($request->entirePage);
        // $data = [
        //     'reportID' => $request->reportID,
        //     'data' => $request->entirePage,
        //     'childName' => $request->childName
        // ];

        // $pdf = PDF::loadView('referralPDF', $data);
        // $pdf->save($storagePath . '/referral_report.pdf');

        $data = array();
        $data['enrollmentId'] = $request->enrollment_id;
        $data['email_content'] = $request->email_content;
        $data['ovm_report'] = $storagePath . '/referral_report.pdf';
        $data['notification'] = 'referral_report/' . $folderPath . '/' . 'referral_report.pdf';

        $encryptArray = $this->encryptData($data);

        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/referral/report/send';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        return true;
    }

}
