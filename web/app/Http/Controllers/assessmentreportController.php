<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Jobs\RenderPdfJob;
use PhpParser\Node\Stmt\TryCatch;

class assessmentreportController extends BaseController
{
    public function index()
    {
        try {
            $permission_data = $this->FillScreensByUser();
            $screen_permission = $permission_data[0];
            $method = 'Method => assessmentreportController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport';

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data;
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];

                    return view('assessmentreport.index', compact('rows', 'screens', 'modules', 'screen_permission'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                //    dd($objData);
                return Redirect::back()
                    ->with('fail', $objData->Message);
                echo json_encode($objData->Message);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function report_list()
    {
        try {
            $method = 'Method => assessmentreportController => report_list';
            $gatewayURL = config('setting.api_gateway_url') . '/sail/report/list';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data; //dd($rows);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('assessmentreport.reportindex', compact('rows', 'screens', 'modules', 'screen_permission'));
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
    }

    public function index_data()
    {
        try {
            $method = 'Method => assessmentreportController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendationreport';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $row = $parant_data;
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('recommendation.index', compact('row', 'screens', 'modules', 'screen_permission'));
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
    }

    public function create(Request $request)
    {

        try {
            $method = 'Method => assessmentreportController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $enrollment_details = $parant_data['enrollment_details'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];

                    $page8 = $parant_data['page8'];
                    $page6 = $parant_data['page6'];
                    $observations = $parant_data['observations'];
                    $perskill = $parant_data['perskill'];
                    $subskill = $parant_data['subskill'];
                    $activitys = $parant_data['activitys'];
                    $excludedSteps = [1, 2, 3, 6, 12, 13, 14, 15];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    // return view('assessmentreport.create', compact('subskill', 'perskill', 'activitys', 'observations', 'pages', 'page8', 'page6', 'report', 'enrollment_details', 'screens', 'modules'));
                    return view('assessmentreport.new_report', compact('excludedSteps', 'subskill', 'perskill', 'activitys', 'observations', 'pages', 'report', 'enrollment_details', 'screens', 'modules'));
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

    public function create_data(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $enrollment_details = $parant_data['enrollment_details'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $totalPage = $parant_data['totalPage'];
                    $page7 = $parant_data['page7'];
                    $page6 = $parant_data['page6'];
                    $areas = $parant_data['areas'];
                    $description = $parant_data['description'];
                    $page7Max = $parant_data['page7Max'];
                    $components = $parant_data['components'];
                    $tiers = $parant_data['tiers'];
                    // dd($tiers);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('recommendation.create', compact('tiers', 'components', 'page7Max', 'description', 'areas', 'pages', 'page7', 'page6', 'totalPage', 'report', 'enrollment_details', 'screens', 'modules'));
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

    public function new_store(Request $request)
    {
        try { //dd($request->meeting_description);
            // RenderPdfJob::dispatch('Test')->delay(now()->addMinutes(1));
            // dd($request);
            $method = 'Method => MasterAssessmentreportController => store';
            // return Redirect(url()->previous())->with('page', 2);
            $btn_statu = $request->btn_statu;
            $currentPage = $request->currentPage;

            $data = array();
            $data['dor'] = $request->dor;
            $data['signature'] = $request->signature;
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $data['rec_rows2'] = $request->rec_rows2;
            $data['activity'] = $request->activity;
            $data['observation'] = $request->observation;
            $data['evidence'] = $request->evidence;
            $data['recommendation'] = $request->recommendation;
            $data['removedPages'] = explode(",", $request->removedPages);
            $data['switch'] = ($request->switch != null ? implode(',', $request->switch) : '');
            $data['switch2'] = ($request->switch2 != null ? implode(',', $request->switch2) : '');

            $encryptArray = $this->encryptData($data);
            // dd($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/assessment/new/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $rId = $objData->Data;
                    $parant_data = json_decode(json_encode($objData->Data), true);


                    // $this->assessment_report($objData->enrollmentId, $objData->reports_id);
                    // return redirect(route('assessment.report.SummaryReportSave', $this->encryptData($objData->reports_id)))->with('page', $currentPage);
                    return redirect(route('assessmentreport.edit', $this->encryptData($objData->reports_id)))->with('page', $currentPage);
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
    public function new_update(Request $request)
    {
        $method = 'Method => MasterAssessmentreportController => new_update';
        try { //dd($request);            
            $page = $request->Page;
            $data = array();
            $data['dor'] = $request->dor;
            $data['signature'] = $request->signature;
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $data['rec_rows2'] = $request->rec_rows2;
            $data['recommendation'] = $request->recommendation;
            $data['activity'] = $request->activity;
            $data['observation'] = $request->observation;
            $data['evidence'] = $request->evidence;
            $data['switch_radio'] = $request->switch_radio_values;
            // dd($data['recommendation'], $data['evidence']);
            $data['removedPages'] = explode(",", $request->removedPages);
            $data['switch'] = ($request->switch != null ? implode(',', $request->switch) : '');
            $data['switch2'] = ($request->switch2 != null ? implode(',', $request->switch2) : '');
            $encryptArray = $this->encryptData($data);

            $state = $request->state;
            $currentPage = $request->currentPage;
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/assessment/new/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    Cache::put('assessment_report_' . $objData->reports_id, $objData->Data, 3600);
                    $assessment_value = Cache::get('assessment_report_' . $objData->reports_id);
                    // dd([
                    //     'cache_key' => 'assessment_report'.$objData->reports_id,
                    //     'stored_value' => $objData->Data,
                    //     'retrieved_value' => $assessment_value
                    // ]);
                    // dd($this->decryptData($objData->Data) , 'asd');
                    if ($state == 'Saved') {
                        return redirect(route('assessmentreport.edit', $this->encryptData($objData->reports_id)))->with('page', $currentPage);
                    }
                    return redirect(route('assessment.report.preview', $this->encryptData($objData->reports_id)))
                        ->with('success', 'The Assessment Report has been submitted successfully.')
                        ->with('page', $page);
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
    public function recommendation_update(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => store';
            $currentPage = 1;
            $data = array();
            $data['dor'] = $request->dor;
            $data['signature'] = $request->signature;
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $data['components'] = $request->components;
            $data['tiers'] = $request->tiers;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/new/update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    // if ($objData->check == 0) {
                    return redirect(route('recommendation.report.render', $this->encryptData($objData->reports_id)))
                        ->with('success', 'The  Recommendation Report has been submitted successfully')
                        ->with('page', $currentPage);
                    //return redirect(route('recommendation.report.render', $this->encryptData($objData->reports_id)))->with('success', 'The  Recommendation Report has been submitted successfully');
                    // }
                    // return Redirect::back()->with('page', $currentPage);
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
    public function edit(Request $request, $id)
    {

        try {

            $method = 'Method => NewenrollementController => edit';
            $page = $request->session()->get('page');

            $currentPage = $request->currentPage;
            // echo json_encode($id);exit;
            // Retrieve the summary_report from the session data
            $summaryReport = $request->session()->get('summary_report');

            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report']; //dd($report);
                    $pages = $parant_data['pages'];
                    // $page6 = $parant_data['page6'];
                    $page8 = $parant_data['page8'];
                    // $questions = $parant_data['questions'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    // $evidance = $parant_data['evidance'];
                    $details = $parant_data['details'];
                    $details2 = $parant_data['details2'];
                    $details3 = $parant_data['details3'];
                    $perskill = $parant_data['perskill'];
                    $subskill = $parant_data['subskill'];
                    $observation_act = $parant_data['observation_act'];
                    $signature = json_decode($report['signature'], true);
                    $sensory_recommendation = json_decode($page8['recommendation'], true);
                    $assessment_recommendation = $parant_data['assessment_recommendation'];
                    $verifiedActivities = $parant_data['verifiedActivities'];

                    $recommendation_lookup = [];

                    foreach ($assessment_recommendation as $rec) {
                        $skill_id = $rec['skill_id'] ?? 'null';
                        $skill_type_id = $rec['skill_type_id'];
                        $recommendation_lookup[$skill_id][$skill_type_id] = $rec['recommendation'];
                    }

                    $skill_id = array();
                    foreach ($subskill as $subs) {
                        array_push($skill_id, $subs['skill_id']);
                    }

                    $c_report = $report['child_contact_email'];
                    $reports_flag = $parant_data['reports_flag'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessmentreport.edit', compact('verifiedActivities', 'id', 'recommendation_lookup', 'sensory_recommendation', 'signature', 'currentPage', 'skill_id', 'subskill', 'perskill', 'details', 'details2', 'details3', 'activitys', 'observations', 'pages', 'page8', 'report', 'screens', 'modules', 'observation_act', 'c_report', 'page', 'reports_flag'));
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

    public function recommendation_edit(Request $request, $id)
    {
        try {
            $method = 'Method => NewenrollementController => show';
            $currentPage = $request->currentPage;
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $page6 = $parant_data['page6'];
                    $page7 = $parant_data['page7'];
                    $areas = $parant_data['areas'];
                    $description = $parant_data['description'];
                    $components = $parant_data['components'];
                    $signature = json_decode($report[0]['signature'], true);
                    $tiers = $parant_data['tiers'];
                    $c_report = $report[0]['child_contact_email'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('recommendation.edit', compact('tiers', 'components', 'currentPage', 'description', 'areas', 'pages', 'page6', 'page7', 'report', 'screens', 'modules', 'signature', 'c_report'));
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

    public function show($id)
    {
        try {
            $method = 'Method => NewenrollementController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages']; //dd($pages);
                    $totalPage = $parant_data['totalPage'];
                    $page6 = $parant_data['page6'];
                    $page8 = $parant_data['page8'];
                    $questions = $parant_data['questions'];
                    $details = $parant_data['details'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    $evidance = $parant_data['evidance'];
                    $perskill = $parant_data['perskill'];
                    $details2 = $parant_data['details2'];
                    $subskill = $parant_data['subskill'];
                    $details3 = $parant_data['details3'];
                    //    dd($details3);

                    // PDF
                    $folderPath = $report[0]['child_contact_email']; //dd($folderPath);
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/assessment_report/' . $folderPath;

                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/assessment_report/';
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }

                    $data = [
                        'pages' => $parant_data['pages'],
                        'child_name' => $report[0]['child_name'],
                        'child_dob' => $report[0]['child_dob'],
                        'dor' => now()->isoFormat('DD-MM-YYYY'),
                    ];
                    // dd($data);
                    $pdf = PDF::loadView('assessmentreport.assessmentReportTemp', compact('data'))->setPaper('legal', 'potrait');
                    $pdf->save($storagePath . '/Assessment_Executive_Report.pdf');


                    $pdf = PDF::loadView('assessmentreport.assessmentReportTemp1', compact('data', 'details3', 'subskill', 'details2', 'perskill', 'evidance', 'observations', 'details', 'activitys', 'questions', 'page6', 'page8', 'totalPage', 'pages', 'report'))->setPaper('legal', 'landscape');
                    $pdf->save($storagePath . '/Assessment_Detail_Summary_Report.pdf');

                    $reportURLs = array(
                        'executive_report' => '/assessment_report/' . $folderPath . '/Assessment_Executive_Report.pdf',
                        'summary_report' => '/assessment_report/' . $folderPath . '/Assessment_Detail_Summary_Report.pdf'
                    );
                    // dd($reportURLs);
                    // End PDF

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessmentreport.PDFpreview', compact('report', 'screens', 'modules', 'reportURLs'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }

        //

    }

    public function AssesmentReportPreview(Request $request, $id)
    {
        $method = 'Method => assessmentreportController => AssesmentReportPreview';
        try { //dd($request);            
            $page = $request->session()->get('page');

            if ($request->isMethod('post')) {
                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/assessment_report/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/assessment_report/';
                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;
                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }

                $htmlContent = $request->input('executive_report');
                $data = $this->decryptData($request->data);
                $pdf = PDF::loadView('assessmentreport.ExecutiveRender', compact('htmlContent', 'data'));
                $pdf->save($storagePath . '/Assessment_Executive_Report.pdf');
                return redirect(route('assessment.report.render', $id))->with('page',  $data['current_page']);
            }
            $assessment_value = Cache::get('assessment_report_' . $this->decryptData($id));

            if ($assessment_value === null) {
                $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            } else {
                $assessment_value = $this->decryptData($assessment_value);
                $response = $assessment_value->getContent();
            }
            // dd($assessment_value);
            // dd('New');
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report']; //dd($report);
                    $pages = $parant_data['pages']; //dd($pages);
                    $totalPage = $parant_data['totalPage'];
                    $page8 = $parant_data['page8'];
                    $details = $parant_data['details'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    $perskill = $parant_data['perskill'];
                    $details2 = $parant_data['details2'];
                    $subskill = $parant_data['subskill'];
                    $details3 = $parant_data['details3'];
                    $signature = json_decode($report['signature'], true);

                    // PDF
                    $folderPath = $report['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/assessment_report/' . $folderPath;

                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/assessment_report/';
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }

                    $data = [
                        'report_id' => $report['report_id'],
                        'pages' => $parant_data['pages'],
                        'child_name' => $report['child_name'],
                        'child_dob' => $report['child_dob'],
                        'dor' => $report['dor'],
                        'email' => $report['child_contact_email'],
                        'signature' => $signature,
                        'current_page' => $page,
                    ];
                    return view('assessmentreport.AssessmentReport', compact('data'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }
    }

    public function AssesmentReportRenderPreview(Request $request, $id)
    {
        try {
            $method = 'Method => assessmentreportController => AssesmentReportRenderPreview';
            $page = $request->session()->get('page');

            if ($request->isMethod('post')) {
                // dd($id);
                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/assessment_report/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/assessment_report/';
                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;
                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }

                $htmlContent = $request->input('summary_report');
                $data = $this->decryptData($request->data);
                $pdf = PDF::loadView('assessmentreport.SummaryRender', compact('htmlContent', 'data'))->setPaper('legal', 'landscape');
                $pdf->save($storagePath . '/Assessment_Detail_Summary_Report.pdf');
                $reportURLs = array(
                    'executive_report' => '/assessment_report/' . $folderPath . '/Assessment_Executive_Report.pdf?v=' . time(),
                    'summary_report' => '/assessment_report/' . $folderPath . '/Assessment_Detail_Summary_Report.pdf?v=' . time()
                );

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                if ($data['report_status'] == "Submitted") {
                    return view('assessmentreport.PDFpreview', compact('data', 'screens', 'modules', 'reportURLs'));
                } else {
                    return redirect(route('assessmentreport.edit', $this->encryptData($data['report_id'])))->with('page', $data['page']);
                }
            }

            $assessment_value = Cache::get('assessment_report_' . $this->decryptData($id));

            // if ($assessment_value === null) {
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // } else {
            //     $assessment_value = $this->decryptData($assessment_value);
            //     $response = $assessment_value->getContent();
            // }

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $totalPage = $parant_data['totalPage'];
                    $page8 = $parant_data['page8'];
                    $details = $parant_data['details'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    $perskill = $parant_data['perskill'];
                    $details2 = $parant_data['details2'];
                    $subskill = $parant_data['subskill'];
                    $details3 = $parant_data['details3'];
                    $email = $parant_data['email'];
                    $verifiedActivities = $parant_data['verifiedActivities'];
                    $signature = json_decode($report['signature'], true);

                    // PDF
                    $folderPath = $report['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/assessment_report/' . $folderPath;

                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/assessment_report/';
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }

                    $sensory_recommendation = json_decode($page8['recommendation'], true);
                    $assessment_recommendation = $parant_data['assessment_recommendation'];

                    $recommendation_lookup = [];

                    foreach ($assessment_recommendation as $rec) {
                        $skill_id = $rec['skill_id'] ?? 'null';
                        $skill_type_id = $rec['skill_type_id'];
                        $recommendation_lookup[$skill_id][$skill_type_id] = $rec['recommendation'];
                    }

                    $data = [
                        'report_id' => $report['report_id'],
                        'enrollment_id' => $report['enrollment_id'],
                        'pages' => $parant_data['pages'],
                        'child_name' => $report['child_name'],
                        'child_dob' => $report['child_dob'],
                        'dor' => $report['dor'],
                        'email' => $report['child_contact_email'],
                        'signature' => $signature,
                        'email_draft' => $email,
                        'report_status' => $report['status'],
                        'page' => $page,
                        'objData' => $this->encryptData($objData),
                        'isTemp' => false,
                        'sensory_recommendation' => $sensory_recommendation,
                        'recommendation_lookup' => $recommendation_lookup,
                        'verifiedActivities' => $verifiedActivities
                    ];
                    // dd($data);

                    return view('assessmentreport.AssessmentReportSummary', compact('data', 'details3', 'subskill', 'details2', 'perskill', 'observations', 'details', 'activitys', 'page8', 'totalPage', 'pages', 'report', 'verifiedActivities'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }
    }

    public function Recomendation_show($id)
    {
        try {
            $method = 'Method => assessmentreportController => Recomendation_show';
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $page6 = $parant_data['page6'];
                    $page7 = $parant_data['page7'];
                    $areas = $parant_data['areas'];
                    $areas1 = $parant_data['areas1'];
                    $description = $parant_data['description'];
                    $page7Max = $parant_data['page7Max'];
                    $components = $parant_data['components'];
                    // dd($page7Max);
                    // PDF
                    $folderPath = $report[0]['child_contact_email']; //dd($folderPath);

                    //$folderPath = str_replace(' ', '-', $folderPath);
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/recommendation_report/' . $folderPath;


                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/recommendation_report/';

                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;

                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }
                    // $data = [
                    //     'reportID' => $request->reportID,
                    //     'data' => $request->entirePage
                    // ];
                    $pdf = PDF::loadView('recommendation.myPDF', compact('components', 'page7Max', 'description', 'areas1', 'areas', 'pages', 'page6', 'page7', 'report'))->setPaper('legal', 'landscape');
                    $pdf->save($storagePath . '/Recommendation_Report.pdf');
                    // dd($storagePath . '/Recommendation_Report.pdf');
                    // End PDF
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $viewPDF = '/recommendation_report/' . $folderPath . '/Recommendation_Report.pdf';
                    return view('recommendation.PDFpreview', compact('components', 'page7Max', 'description', 'areas1', 'areas', 'pages', 'page6', 'page7', 'report', 'screens', 'modules', 'viewPDF'));
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
    public function RecomendationPreview(Request $request, $id)
    {
        try {
            $method = 'Method => assessmentreportController => Recomendation_show';
            $page = 1;
            //dd($page);
            if ($request->isMethod('post')) {
                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/recommendation_report/' . $folderPath;


                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/recommendation_report/';

                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;

                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }
                $htmlContent = $request->input('report');
                // $this->WriteFileLog("htmlContent");
                // $this->WriteFileLog($htmlContent);
                // $this->WriteFileLog("htmlContent end");
                $data = $this->decryptData($request->data);

                //dd($request->session()->get('page'));
                $pdf = PDF::loadView('recommendation.RecommendationRender', compact('htmlContent'))->setPaper('legal', 'landscape');
                $pdf->save($storagePath . '/Recommendation_Report.pdf');
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $viewPDF = '/recommendation_report/' . $folderPath . '/Recommendation_Report.pdf';
                if ($data['pages'][0]['status'] == "Submitted") {
                    return view('recommendation.PDFpreview', compact('data', 'screens', 'modules', 'viewPDF'));
                } else {
                    return redirect(route('recommendation.edit', $id))->with('page', $page);
                }
                // return view('recommendation.PDFpreview', compact('data', 'screens', 'modules', 'viewPDF'));
            }
            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                // dd($objData);
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $page6 = $parant_data['page6'];
                    $page7 = $parant_data['page7'];
                    $areas = $parant_data['areas'];
                    $areas1 = $parant_data['areas1'];
                    $description = $parant_data['description'];
                    $page7Max = $parant_data['page7Max'];
                    $components = $parant_data['components'];
                    $email = $parant_data['email'];
                    $signature = json_decode($report[0]['signature'], true);
                    $tiers = $parant_data['tiers'];
                    // dd($areas , $page7);
                    // PDF
                    $folderPath = $report[0]['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/recommendation_report/' . $folderPath;


                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/recommendation_report/';

                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;

                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }
                    // $data = [
                    //     'reportID' => $request->reportID,
                    //     'data' => $request->entirePage
                    // ];
                    $data = [
                        'report_id' => $report[0]['report_id'],
                        'enrollment_id' => $report[0]['enrollment_id'],
                        'child_gender' => $report[0]['child_gender'],
                        'pages' => $parant_data['pages'],
                        'child_name' => $report[0]['child_name'],
                        'child_dob' => $report[0]['child_dob'],
                        'dor' => $report[0]['dor'],
                        'email' => $report[0]['child_contact_email'],
                        'signature' => $signature,
                        'email_draft' => $email,
                    ];
                    return view('recommendation.RecommendationReport', compact('data', 'components', 'page7Max', 'description', 'areas1', 'areas', 'pages', 'page6', 'page7', 'report', 'tiers'));
                    $pdf = PDF::loadView('recommendation.myPDF', compact('components', 'page7Max', 'description', 'areas1', 'areas', 'pages', 'page6', 'page7', 'report'))->setPaper('legal', 'landscape');
                    $pdf->save($storagePath . '/Recommendation_Report.pdf');
                    // dd($storagePath . '/Recommendation_Report.pdf');
                    // End PDF
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $viewPDF = '/recommendation_report/' . $folderPath . '/Recommendation_Report.pdf';
                    return view('recommendation.PDFpreview', compact('components', 'page7Max', 'description', 'areas1', 'areas', 'pages', 'page6', 'page7', 'report', 'screens', 'modules', 'viewPDF'));
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

    public function assessment_report($id, $reports_id)
    {

        $method = 'Method => assessmentreportController => assessment_report';

        $folderPath = $id;

        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ASSESSMENT_REPORT_SAIL/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ASSESSMENT_REPORT_SAIL/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }


        $documentName = 'ASSESSMENT_REPORT_SAIL.pdf';
        $document_name = 'ASSESSMENT_REPORT_SAIL';
        $input = base_path() . '/reports/ASSESSMENT_REPORT_SAIL.jasper';


        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = $storagePath . '/' . $documentName;
        $output_1 = $storagePath . '/' . $document_name;
        $storagePath = public_path() . '/ASSESSMENT_REPORT_SAIL/';
        $report_path = public_path() . '/ASSESSMENT_REPORT_SAIL/' . $folderPath;

        // dd($output_1);

        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'reports_id' => $reports_id,

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
        //echo json_encode($options); exit;
        $jasper->process(
            $input,
            $output_1,
            $options
        )->execute();

        $documentName = 'ovm_report.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );

        $data = array();
        $data['enrollmentId'] = $id;
        $data['ovm_report'] = $output;
        $data['notification'] = 'ASSESSMENT_REPORT_SAIL/' . $folderPath . '/' . 'ASSESSMENT_REPORT_SAIL.pdf';

        $encryptArray = $this->encryptData($data);



        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/sail/sail_assessment';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    //recommendation



    public function recommendation_new_store(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method => assessmentreportController => recommendation_new_store';
            $currentPage = $request->currentPage;
            $data = array();
            $data['dor'] = $request->dor;
            $data['signature'] = $request->signature;
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;
            //$data['recommendation_detail_area_id'] = $request->recommendation_detail_area_id;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $data['components'] = $request->components;
            $data['tiers'] = $request->tiers;

            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/new/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                // dd($objData);
                if ($objData->Code == 200) {
                    // if ($objData->check == 0) {
                    //     return redirect(route('recommendation.report.render', $this->encryptData($objData->reports_id)));
                    // }

                    return redirect(route('recommendation.report.render', $this->encryptData($objData->reports_id)))->with('page', $currentPage);

                    // return redirect(route('recommendation.edit', $this->encryptData($objData->reports_id)))->with('page', $currentPage);
                }
                // if ($objData->Code == 200) {
                //     $rId = $objData->Data;
                //     $parant_data = json_decode(json_encode($objData->Data), true);


                //     // $this->assessment_report($objData->enrollmentId, $objData->reports_id);
                //     return redirect(route('recommendation.report.render1', $this->encryptData($objData->reports_id)))->with('page', $currentPage);
                // }


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

    public function Recommendation_report($id, $reports_id)
    {

        $method = 'Method => assessmentreportController => Recommendation_report';

        $folderPath = $id;

        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/recommendation_report/' . $folderPath;


        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/recommendation_report/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }


        $data = array();
        $data['enrollmentId'] = $id;
        $data['ovm_report'] = $storagePath . '/' . 'Recommendation_Report.pdf';
        $data['notification'] = 'recommendation_report/' . $folderPath . '/' . 'Recommendation_Report.pdf';

        $encryptArray = $this->encryptData($data);



        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/sail_recommendation';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
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
        $storagePath = public_path() . '/recommendation_report/' . $folderPath;


        // if (!File::exists($storagePath)) {
        //     $storagePath = public_path() . '/recommendation_report/';

        //     $arrFolder = explode('/', $folderPath);
        //     foreach ($arrFolder as $key => $value) {
        //         $storagePath .= '/' . $value;

        //         if (!File::exists($storagePath)) {
        //             File::makeDirectory($storagePath);
        //         }
        //     }
        // }
        // $this->WriteFileLog($request->entirePage);
        // $data = [
        //     'reportID' => $request->reportID,
        //     'data' => $request->entirePage
        // ];
        // $pdf = PDF::loadView('myPDF', $data)->setPaper('a4', 'landscape');
        // $pdf->save($storagePath . '/Recommendation_Report.pdf');
        // dd($storagePath . '/Recommendation_Report.pdf');
        $Accept = URL::signedRoute('referral_request', ['id' => $this->encryptData($request->child_contact_email), 'action' => 'Accept']);
        $Denial = URL::signedRoute('referral_request', ['id' => $this->encryptData($request->child_contact_email), 'action' => 'Denial']);

        // $this->WriteFileLog($Denial);
        $data = array();
        $data['enrollmentId'] = $request->enrollment_id;
        $data['email_content'] = $request->email_content;
        $data['ovm_report'] = $storagePath . '/Recommendation_Report.pdf';
        $data['notification'] = 'recommendation_report/' . $folderPath . '/' . 'Recommendation_Report.pdf';
        $data['Accept'] = $Accept;
        $data['Denial'] = $Denial;
        // dd($data);
        $encryptArray = $this->encryptData($data);

        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/sail_recommendation';

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
        //
        // $data = [
        //     'reportID' => $request->reportID,
        //     'data' => $request->entirePage
        // ];
        // return PDF::loadHTML($request->entirePage)->save('C:\Users\user\Desktop\pdf/genratedPDF.pdf');
        // //
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml($request->entirePage);
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // $dompdf->stream();
    }

    public function generatePDFAssessment(Request $request)
    {
        //dd($request->view1);
        $method = 'Method => assessmentreportController => Recommendation_report';
        $folderPath = $request->child_contact_email;
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/assessment_report/' . $folderPath;

        $page1 = $request->view1;
        $page2 = $request->view2;

        // if (!File::exists($storagePath)) {
        //     $storagePath = public_path() . '/assessment_report/';
        //     $arrFolder = explode('/', $folderPath);
        //     foreach ($arrFolder as $key => $value) {
        //         $storagePath .= '/' . $value;
        //         if (!File::exists($storagePath)) {
        //             File::makeDirectory($storagePath);
        //         }
        //     }
        // }

        // $data = [
        //     'data' => $page1,
        //     'child_name' => $request->child_name,
        //     'child_dob' => $request->child_dob,
        //     'dor' => now()->isoFormat('DD-MM-YYYY'),
        // ];

        // $pdf = PDF::loadView('assessmentReportTemp', compact('data'));
        // $pdf->save($storagePath . '/Assessment_Executive_Report.pdf');

        // $data = [
        //     'data' => $page2,
        //     'child_name' => $request->child_name,
        //     'child_dob' => $request->child_dob,
        //     'dor' => now()->isoFormat('DD-MM-YYYY'),
        // ];

        // $pdf = PDF::loadView('assessmentReportTemp1', compact('data'));
        // $pdf->save($storagePath . '/Assessment_Detail_Summary_Report.pdf');
        // return '/assessment_report/' . $folderPath . '/Assessment_Executive_Report.pdf';

        $data = array();
        $data['enrollmentId'] = $request->enrollment_id;
        $data['ovm_report'] = $storagePath . '/Assessment_Executive_Report.pdf';
        $data['ovm_report1'] = $storagePath . '/Assessment_Detail_Summary_Report.pdf';
        $data['notification'] = 'assessment_report/' . $folderPath . '/' . 'Assessment_Executive_Report.pdf';
        $data['notification1'] = 'assessment_report/' . $folderPath . '/' . 'Assessment_Detail_Summary_Report.pdf';
        $data['email_content'] = $request->email_content;
        // $this->WriteFileLog($data);
        // dd($data);
        $encryptArray = $this->encryptData($data);

        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/sail/sail_assessment';

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
        //
        // $data = [
        //     'reportID' => $request->reportID,
        //     'data' => $request->entirePage
        // ];
        // return PDF::loadHTML($request->entirePage)->save('C:\Users\user\Desktop\pdf/genratedPDF.pdf');
        // //
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml($request->entirePage);
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // $dompdf->stream();
    }

    public function areaname_ajax(Request $request)

    {
        $method = 'Method => assessmentreportController => areaname_ajax';
        try {

            $area_name = $request->area_name;



            $request = array();

            $request['requestData'] = $area_name;

            $gatewayURL = config('setting.api_gateway_url') . '/areaname/master/ajax';
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
    public function auto_store(Request $request)
    {
        try { //dd($request->meeting_description);
            //dd($request);
            $method = 'Method => MasterAssessmentreportController => store';

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }


            $btn_statu = $request->btn_statu;

            $data = array();
            $data['state'] = $request->state;
            $data['enrollmentId'] = $request->enrollmentId;
            $data['meeting_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $data['activity'] = $request->activity;
            $data['observation'] = $request->observation;
            $data['evidence'] = $request->evidence;
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/report/assessment/new/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    $rId = $objData->Data;
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    if ($objData->check == 0) {
                        // $this->assessment_report($objData->enrollmentId, $objData->reports_id);
                        return redirect(route('assessment.report.preview', $this->encryptData($objData->reports_id)));
                    }

                    return redirect(route('assessmentreport.index'))
                        ->with('success', 'Page Created Successfully');
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

    public function AssesmentReportPreview1(Request $request, $id)
    {
        $method = 'Method => assessmentreportController => AssesmentReportPreview1';
        try { //dd($request);

            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];

                    // PDF
                    $folderPath = $report['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);

                    $reportURLs = array(
                        'executive_report' => '/assessment_report/' . $folderPath . '/Assessment_Executive_Report.pdf',
                        'summary_report' => '/assessment_report/' . $folderPath . '/Assessment_Detail_Summary_Report.pdf'
                    );
                    // End PDF

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessmentreport.reportshow', compact('report', 'screens', 'modules', 'reportURLs'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }
    }

    public function RecomendationPreview1(Request $request, $id)
    {
        try {
            $method = 'Method => assessmentreportController => RecomendationPreview1';

            $gatewayURL = config('setting.api_gateway_url') . '/report/recommendation/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];

                    $folderPath = $report[0]['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $viewPDF = '/recommendation_report/' . $folderPath . '/Recommendation_Report.pdf';
                    return view('recommendation.reportshow', compact('report', 'screens', 'modules', 'viewPDF'));
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
    public function observation_view(Request $request)
    {
        // $this->WriteFileLog($request);
        try {
            $method = 'Method => assessmentreportController => observation_view';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            // echo json_encode($id);exit;
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/observation';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                    echo json_encode($parant_data);
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
    public function meetingdes_updation(Request $request)
    {
        // $this->WriteFileLog($request);
        try {
            $method = 'Method => assessmentreportController => meetingdes_updation';
            $data = array();
            $data['step_id'] = $request->step;
            $data['reports_id'] = $request->reports_id;
            $data['checking'] = $request->checking;
            // echo json_encode($id);exit;
            $encryptArray = $this->encryptData($data);


            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/report/meeting_description_ass/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                    echo json_encode($parant_data);
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

    public function reportRepublish(Request $request)
    {
        $method = 'Method => assessmentreportController => reportRepublish';
        try {
            $data = array();
            $data['reportID'] = $request->reportID;
            $data['comment'] = $request->comment;
            $data['type'] = $request->type;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/assessment/report/republish';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // $this->WriteFileLog($parant_data);
                    return $parant_data;
                    echo json_encode($parant_data);
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

    public function getComments(Request $request)
    {
        $method = 'Method => assessmentreportController => getComments';
        try {
            $data = array();
            $data['reportID'] = $request->reportID;
            $data['type'] = $request->type;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/assessment/report/get/comments';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // $this->WriteFileLog($parant_data);
                    return $parant_data;
                    echo json_encode($parant_data);
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

    public function ExecutiveReportSave(Request $request, $id)
    {
        $method = 'Method => assessmentreportController => ExecutiveReportSave';
        try { //dd($request);            
            $page = $request->session()->get('page');

            if ($request->isMethod('post')) {

                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/assessment_report/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/assessment_report/';
                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;
                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }

                $htmlContent = $request->input('executive_report');
                $data = $this->decryptData($request->data);
                $pdf = PDF::loadView('assessmentreport.ExecutiveRender', compact('htmlContent', 'data'));
                $pdf->save($storagePath . '/Assessment_Executive_Report.pdf');
                return view('autoclose');
                // $objData = $request->input('objData');
                // $objData = $this->decryptData($objData);
                // if ($objData->Code == 200) {
                //     $parant_data = json_decode(json_encode($objData->Data), true);
                //     $report = $parant_data['report']; 
                //     $pages = $parant_data['pages'];
                //     $page8 = $parant_data['page8'];
                //     $activitys = $parant_data['activitys'];
                //     $observations = $parant_data['observations'];
                //     $details = $parant_data['details'];
                //     $details2 = $parant_data['details2'];
                //     $details3 = $parant_data['details3'];
                //     $perskill = $parant_data['perskill'];
                //     $subskill = $parant_data['subskill'];
                //     $observation_act = $parant_data['observation_act'];
                //     $signature = json_decode($report['signature'], true);
                //     $sensory_recommendation = json_decode($page8['recommendation'], true);
                //     $assessment_recommendation = $parant_data['assessment_recommendation'];
                //     $currentPage = 1;
                //     $recommendation_lookup = [];

                //     foreach ($assessment_recommendation as $rec) {
                //         $skill_id = $rec['skill_id'] ?? 'null';
                //         $skill_type_id = $rec['skill_type_id'];
                //         $recommendation_lookup[$skill_id][$skill_type_id] = $rec['recommendation'];
                //     }

                //     $skill_id = array();
                //     foreach ($subskill as $subs) {
                //         array_push($skill_id, $subs['skill_id']);
                //     }

                //     $c_report = $report['child_contact_email'];
                //     $reports_flag = $parant_data['reports_flag'];
                //     $menus = $this->FillMenu();
                //     $screens = $menus['screens'];
                //     $modules = $menus['modules'];

                //     return view('assessmentreport.edit', compact('id','recommendation_lookup', 'sensory_recommendation', 'signature', 'currentPage', 'skill_id', 'subskill', 'perskill', 'details', 'details2', 'details3', 'activitys', 'observations', 'pages', 'page8', 'report', 'screens', 'modules', 'observation_act', 'c_report', 'page', 'reports_flag'));
                // }
                // return redirect(route('assessment.report.render', $id))->with('page',  $data['current_page']);
            }
            $assessment_value = Cache::get('assessment_report_' . $this->decryptData($id));

            if ($assessment_value === null) {
                $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            } else {
                $assessment_value = $this->decryptData($assessment_value);
                $response = $assessment_value->getContent();
            }
            // dd($assessment_value);
            // dd('New');
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $report = $parant_data['report']; //dd($report);
                    $pages = $parant_data['pages']; //dd($pages);
                    $totalPage = $parant_data['totalPage'];
                    $page8 = $parant_data['page8'];
                    $details = $parant_data['details'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    $perskill = $parant_data['perskill'];
                    $details2 = $parant_data['details2'];
                    $subskill = $parant_data['subskill'];
                    $details3 = $parant_data['details3'];
                    $signature = json_decode($report['signature'], true);

                    // PDF
                    $folderPath = $report['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/assessment_report/' . $folderPath;

                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/assessment_report/';
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }

                    $data = [
                        'report_id' => $report['report_id'],
                        'pages' => $parant_data['pages'],
                        'child_name' => $report['child_name'],
                        'child_dob' => $report['child_dob'],
                        'dor' => $report['dor'],
                        'email' => $report['child_contact_email'],
                        'signature' => $signature,
                        'current_page' => $page,
                        'objData' => $this->encryptData($objData)
                    ];
                    $this->WriteFileLog('Two');
                    return view('assessmentreport.TempAssessmentReport', compact('data'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }
    }

    public function SummaryReportSave(Request $request, $id)
    {
        $method = 'Method => assessmentreportController => SummaryReportSave';
        try {

            $page = $request->session()->get('page');

            if ($request->isMethod('post')) {
                // dd($id);
                $folderPath = $request->input('email');
                $findString = array(' ', '&');
                $replaceString = array('-', '-');
                $folderPath = str_replace($findString, $replaceString, $folderPath);
                $storagePath = public_path() . '/assessment_report/' . $folderPath;

                if (!File::exists($storagePath)) {
                    $storagePath = public_path() . '/assessment_report/';
                    $arrFolder = explode('/', $folderPath);
                    foreach ($arrFolder as $key => $value) {
                        $storagePath .= '/' . $value;
                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath);
                        }
                    }
                }

                $htmlContent = $request->input('summary_report');
                $data = $this->decryptData($request->data);
                $pdf = PDF::loadView('assessmentreport.SummaryRender', compact('htmlContent', 'data'))->setPaper('legal', 'landscape');
                $pdf->save($storagePath . '/Assessment_Detail_Summary_Report.pdf');
                return view('autoclose');
            }

            $assessment_value = Cache::get('assessment_report_' . $this->decryptData($id));

            // if ($assessment_value === null) {
            $gatewayURL = config('setting.api_gateway_url') . '/report/assessmentreport/edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // } else {
            // $assessment_value = $this->decryptData($assessment_value);
            // $response = $assessment_value->getContent();
            // }

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $totalPage = $parant_data['totalPage'];
                    $page8 = $parant_data['page8'];
                    $details = $parant_data['details'];
                    $activitys = $parant_data['activitys'];
                    $observations = $parant_data['observations'];
                    $perskill = $parant_data['perskill'];
                    $details2 = $parant_data['details2'];
                    $subskill = $parant_data['subskill'];
                    $details3 = $parant_data['details3'];
                    $email = $parant_data['email'];
                    $verifiedActivities = $parant_data['verifiedActivities'];
                    $signature = json_decode($report['signature'], true);

                    // PDF
                    $folderPath = $report['child_contact_email'];
                    $findString = array(' ', '&');
                    $replaceString = array('-', '-');
                    $folderPath = str_replace($findString, $replaceString, $folderPath);
                    $storagePath = public_path() . '/assessment_report/' . $folderPath;

                    if (!File::exists($storagePath)) {
                        $storagePath = public_path() . '/assessment_report/';
                        $arrFolder = explode('/', $folderPath);
                        foreach ($arrFolder as $key => $value) {
                            $storagePath .= '/' . $value;
                            if (!File::exists($storagePath)) {
                                File::makeDirectory($storagePath);
                            }
                        }
                    }

                    $sensory_recommendation = json_decode($page8['recommendation'], true);
                    $assessment_recommendation = $parant_data['assessment_recommendation'];

                    $recommendation_lookup = [];

                    foreach ($assessment_recommendation as $rec) {
                        $skill_id = $rec['skill_id'] ?? 'null';
                        $skill_type_id = $rec['skill_type_id'];
                        $recommendation_lookup[$skill_id][$skill_type_id] = $rec['recommendation'];
                    }

                    $data = [
                        'report_id' => $report['report_id'],
                        'enrollment_id' => $report['enrollment_id'],
                        'pages' => $parant_data['pages'],
                        'child_name' => $report['child_name'],
                        'child_dob' => $report['child_dob'],
                        'dor' => $report['dor'],
                        'email' => $report['child_contact_email'],
                        'signature' => $signature,
                        'email_draft' => $email,
                        'report_status' => $report['status'],
                        'page' => $page,
                        'objData' => $this->encryptData($objData),
                        'isTemp' => true,
                        'sensory_recommendation' => $sensory_recommendation,
                        'recommendation_lookup' => $recommendation_lookup,
                        'verifiedActivities' => $verifiedActivities

                    ];
                    // dd($data);

                    return view('assessmentreport.AssessmentReportSummary', compact('recommendation_lookup','data', 'details3', 'subskill', 'details2', 'perskill', 'observations', 'details', 'activitys', 'page8', 'totalPage', 'pages', 'report','verifiedActivities'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), '');
        }
    }
}
