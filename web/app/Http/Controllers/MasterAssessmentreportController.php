<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use Log;
use Illuminate\Support\Facades\URL;


class MasterAssessmentreportController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => MasterAssessmentreportController => index';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/master/assessment';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);


        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $rows = $rows['rows'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('assessment_creation.index', compact('user_id', 'modules', 'screens', 'rows'));
        //
    }

    public function create(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => create';

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // $rows =  $parant_data['rows'];
                    //  $email = $parant_data['email'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('assessment_creation.create', compact('screens', 'modules'));
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
    public function master_header(Request $request)
    {
        try {
            // $this->WriteFileLog("web hitted");
            $method = 'Method => MasterAssessmentreportController => master_header';
            $data = array();
            $data['report_name'] = $request->report_name;
            $data['report_type'] = $request->report_type;
            $data['version'] = $request->version;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/header';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                echo $encryptData;
                // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
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
            $method = 'Method => MasterAssessmentreportController => store';

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $btn_statu = $request->btn_statu;

            $data = array();
            $data['report_id'] = $request->report_id;
            $data['page_description'] = $request->meeting_description;
            $data['current_page'] = $request->c_page;
            $data['btn_statu'] = $request->btn_statu;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/store';
            
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            
            $response1 = json_decode($response);
           
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $rId = $objData->Data;

                    if ($btn_statu == 'Completed') {
                        return redirect(route('reports_master.publish_preview', $this->encryptData($rId)))
                            ->with('success', 'Page Created Successfully');
                    } else {
                        return redirect(route('reports_master.edit', $this->encryptData($rId)))
                            ->with('success', 'Page Created Successfully');
                    }
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
    public function edit($id)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $report_name = $report[0]['report_name'];
                     $table_num = $parant_data['recommendation'];
                     $table_num_1 = $parant_data['recommendation_1'];
                     $executive_functioning_details = $parant_data['executive_functioning_details'];
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                     if($report_name=='Assessment Report')  {
                        return view('assessment_creation.add_pages', compact('executive_functioning_details','pages', 'report', 'rows','table_num','table_num_1', 'screens', 'modules'));
                     }
                     elseif($report_name=='Recommendation Report'){
                        return view('assessment_creation.add_recommendation_page', compact('pages', 'report', 'rows','table_num','table_num_1', 'screens', 'modules'));
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

    public function update(Request $request, $id)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => store';

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $data = array();
            $data['report_details_id'] = $this->DecryptData($id);
            $data['page_description'] = $request->meeting_description;
            $data['reports_id'] = $request->reports_id;

            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    // dd($objData->Data);
                    $rId = $objData->Data;
                    return redirect(route('reports_master.edit', $this->encryptData($rId)))
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

    public function show($id)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            // dd($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $totalPage = $parant_data['totalPage'];
                    $recommendation = $parant_data['recommendation'];
                    $recommendation_1 = $parant_data['recommendation_1'];
                    $executive_functioning_details = $parant_data['executive_functioning_details'];


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessment_creation.preview', compact('executive_functioning_details','recommendation_1','recommendation','totalPage', 'pages', 'report', 'rows', 'screens', 'modules'));
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

    public function NewVersion($id)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessment_creation.new_version', compact('pages', 'report', 'rows', 'screens', 'modules'));
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

    public function update_header(Request $request)
    {
        try {

            $method = 'Method => MasterAssessmentreportController => update_header';
            $data = array();
            $data['report_name'] = $request->report_name;
            $data['report_type'] = $request->report_type;
            $data['version'] = $request->version;
            $data['report_id'] = $request->report_id;
            $encryptArray = $this->encryptData($data);//dd($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/header/update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                echo $data;
                // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function publish_preview($id)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $report = $parant_data['report'];
                    $pages = $parant_data['pages'];
                    $role_name = $parant_data['role_name'];
                    $totalPage = $parant_data['totalPage'];


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('assessment_creation.publish_preview', compact('role_name', 'totalPage', 'pages', 'report', 'rows', 'screens', 'modules'));
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

    public function final_submit(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => final_submit';
            $data = array();
            $data['action'] = $request->action;
            $data['report_id'] = $request->report_id;
            $data['report_name'] = $request->report_name;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/final/submit';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                // return redirect(route('reports_master.index'))->with('success', 'Report Published Succesfully');
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                echo $data;
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => update_toggle';
            $data = array();
            $data['is_active'] = $request->is_active;
            $data['f_id'] = $request->f_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/reports_master/update_toggle';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                echo $this->decryptData($response1->Data);
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function repot_store(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => repot_store';

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $btn_statu = $request->btn_statu;

            $data = array();
            $data['report_id'] = $request->report_id;
            $data['page_description'] = $request->meeting_description;
            $data['current_page'] = $request->c_page;
            $data['btn_statu'] = $request->btn_statu;
            $data['rows'] = $request->rows;
            $data['rows2'] = $request->rows2;
            $encryptArray = $this->encryptData($data);
            
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/assessment/report_store';
            
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            
            $response1 = json_decode($response);
           
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $rId = $objData->Data;

                    if ($btn_statu == 'Completed') {
                        return redirect(route('reports_master.publish_preview', $this->encryptData($rId)))
                            ->with('success', 'Page Created Successfully');
                    } else {
                        return redirect(route('reports_master.edit', $this->encryptData($rId)))
                            ->with('success', 'Page Created Successfully');
                    }
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
}
