<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class MasterAssessmentreportController extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => MasterAssessmentreportController => index';


            $rows = DB::table('reports')
                ->select('*')
                ->where('active_flag', 0)
                ->get();

            $response = [
                'rows' => $rows,

            ];




            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function createdata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => MasterAssessmentreportController => createdata';


            $rows = DB::select('select * from activity');


            $response = [
                'rows' => $rows
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function master_header(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => master_header';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'report_name' => $inputArray['report_name'],
                'report_type' => $inputArray['report_type'],
                'version' => $inputArray['version'],
            ];


            $page_header =  DB::table('reports')
                ->insertGetId(
                    [
                        'report_name' => $input['report_name'],
                        'report_type' => $input['report_type'],
                        'version' => $input['version'],
                        'status' => "New",


                    ]
                );




            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $page_header;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function master_header_update(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => master_header_update';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'report_name' => $inputArray['report_name'],
                'report_type' => $inputArray['report_type'],
                'version' => $inputArray['version'],
                'report_id' => $inputArray['report_id']
            ];

            DB::table('reports')
                ->where('reports_id', $input['report_id'])
                ->update([
                    'report_name' => $input['report_name'],
                    // 'report_type' => $input['report_type'],
                    // 'version' => $input['version'],
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => NOW(),
                ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 'Updated Successfully';
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function store_data(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => store_data';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'report_id' => $inputArray['report_id'],
                'page_description' => $inputArray['page_description'],
                'current_page' => $inputArray['current_page'],
                'btn_statu' => $inputArray['btn_statu'],
                'rows' => $inputArray['rows'],
                'rows2' => $inputArray['rows2'],
            ];

            $page = $input['page_description'];
            if ($page != '') {
                $current_page = $input['current_page'];
                $page_store = DB::table('report_details')->insertGetId([
                    'reports_id' => $input['report_id'],
                    'page' => $input['current_page'],
                    'page_description' => $input['page_description'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);

                if ($current_page == 6) {
                    $option = $input['rows'];
                    if (!empty($option)) {
                        $optioncount = count($option);
                        for ($i = 0; $i < $optioncount; $i++) {
                            $t = 'row';
                            $t1 = $i + 1;
                            $iii = $t . $t1;
                            $optionrow = $option[$iii];
                            if (!empty($optionrow)) {
                                // $optionrowcount = count($optionrow);
                                // for ($i = 0; $i < $optionrowcount; $i++) {
                                DB::table('executive_functioning')->insertGetId([
                                    'report_id' => $input['report_id'],
                                    'page_no' => $input['current_page'],
                                    'executive_skills' => $optionrow[1],
                                    'strengths' => $optionrow[2],
                                    'stretches' => $optionrow[3],
                                    'created_by' => auth()->user()->id,
                                    'created_date' => NOW()
                                ]);
                                // }
                            }
                        }
                    }
                }
                if ($current_page == 8) {
                    $option = $input['rows2'];
                    if (!empty($option)) {
                        $optioncount = count($option);
                        for ($i = 0; $i < $optioncount; $i++) {
                            $t = 'row';
                            $t1 = $i + 1;
                            $iii = $t . $t1;
                            $optionrow = $option[$iii];
                            if (!empty($optionrow)) {
                                // $optionrowcount = count($optionrow);
                                // for ($i = 0; $i < $optionrowcount; $i++) {
                                DB::table('sensory_profiling')->insertGetId([
                                    'report_id' => $input['report_id'],
                                    'page_no' => $input['current_page'],
                                    'sensory_profiling1' => $optionrow[1],
                                    'sensory_profiling2' => $optionrow[2],
                                    'created_by' => auth()->user()->id,
                                    'created_date' => NOW()
                                ]);
                                // }
                            }
                        }
                    }
                }
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'pages' => $input['current_page'],
                        'status' => $input['btn_statu'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);
            } else {
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'status' => $input['btn_statu'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['report_id'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function data_edit($id)
    {

        try {

            $method = 'Method => MasterAssessmentreportController => data_edit';

            $id = $this->DecryptData($id);

            $rows = DB::select("SELECT * FROM reports AS a INNER JOIN report_details AS b ON a.reports_id = b.reports_id 
             WHERE b.report_details_id=$id");
            $report = DB::select("SELECT * FROM reports WHERE reports_id = $id");
            $pages = DB::select("SELECT * FROM report_details WHERE reports_id = $id");
            $authID = auth()->user()->id;
            $user = DB::select("SELECT * FROM users AS a INNER JOIN uam_roles AS b ON a.array_roles=b.role_id WHERE a.id = $authID");
            $recommendation = DB::select("SELECT * from recommendation_detail_areas WHERE table_num='1'");
            $recommendation_1 = DB::select("SELECT * from recommendation_detail_areas WHERE table_num='2'");
            $role_name = $user[0]->role_name;
            $totalPage = $report[0]->pages;
            $executive_functioning_details = DB::select("Select * from executive_functioning_details where status=0");
            // $table = $recommendation[0]->table_num;

            $response = [
                'rows' => $rows,
                'report' => $report,
                'pages' => $pages,
                'role_name' => $role_name,
                'totalPage' => $totalPage,
                'recommendation' => $recommendation,
                'recommendation_1' => $recommendation_1,
                'executive_functioning_details' => $executive_functioning_details
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function update_data(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => update_data';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'report_id' => $inputArray['reports_id'],
                'page_description' => $inputArray['page_description'],
                'report_details_id' => $inputArray['report_details_id'],
            ];
            $this->WriteFileLog($input);

            DB::table('report_details')
                ->where('report_details_id', $input['report_details_id'])
                ->update([
                    'page_description' => $input['page_description'],
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => NOW(),
                ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['report_id'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function final_submit(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => final_submit';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'action' => $inputArray['action'],
                'report_id' => $inputArray['report_id'],
                'report_name' => $inputArray['report_name'],

            ];

            $authID = auth()->user()->id;
            $user = DB::select("SELECT * FROM users AS a
            INNER JOIN uam_roles AS b ON a.array_roles=b.role_id
            WHERE a.id = $authID");
            $role_name = $user[0]->role_name;

            if ($role_name != 'IS Head') {
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'status' => 'Published',
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'Report Create',
                            'notification_url' => 'master/preview/' . encrypt($input['report_id']),
                            'megcontent' => $input['report_name'] . " has been Published and waiting for your action",
                            'alert_meg' => $input['report_name'] . " has been Published and waiting for your action",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            } else {
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'status' => 'Approved',
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                        'version' => '1.0 [Final]'
                    ]);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '5'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'Report Create',
                            'notification_url' => 'reports_master/' . encrypt($input['report_id']),
                            'megcontent' => $input['report_name'] . " has been Approved",
                            'alert_meg' => $input['report_name'] . " has been Approved",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            }


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['report_id'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => update_toggle';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'is_active' => $inputArray['is_active'],
                'f_id' => $inputArray['f_id'],
            ];
            // $this->WriteFileLog($input);

            DB::table('report_details')
                ->where('report_details_id', $input['f_id'])
                ->update([
                    'enable_flag' => $input['is_active'],
                ]);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['is_active'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function report_store_data(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => report_store_data';
            $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'report_id' => $inputArray['report_id'],
                'page_description' => $inputArray['page_description'],
                'current_page' => $inputArray['current_page'],
                'btn_statu' => $inputArray['btn_statu'],
                'rows' => $inputArray['rows'],
                'rows2' => $inputArray['rows2'],
            ];

            $page = $input['page_description'];
            if ($page != '') {
                $current_page = $input['current_page'];
                $page_store = DB::table('report_details')->insertGetId([
                    'reports_id' => $input['report_id'],
                    'page' => $input['current_page'],
                    'page_description' => $input['page_description'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);

                if ($current_page == 6) {
                    $option = $input['rows'];
                    if (!empty($option)) {
                        $optioncount = count($option);
                        for ($i = 0; $i < $optioncount; $i++) {
                            $t = 'row';
                            $t1 = $i + 1;
                            $iii = $t . $t1;
                            $optionrow = $option[$iii];
                            if (!empty($optionrow)) {

                                // $optionrowcount = count($optionrow);
                                // for ($i = 0; $i < $optionrowcount; $i++) {
                                DB::table('recommendation_report_detail1')->insertGetId([
                                    'recommendation_detail_area_id' => array_keys($optionrow)[0],
                                    'reports_id' => $input['report_id'],
                                    'page_no' => $input['current_page'],
                                    'strengths' => $optionrow[1],
                                    'recommended_enviroment' => $optionrow[2],
                                    'strategies_command' => $optionrow[3],
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                                // }
                            }
                        }
                    }
                }
                if ($current_page == 7) {
                    $option = $input['rows2'];$this->WriteFileLog(count($option));$this->WriteFileLog($option);exit;
                    if (!empty($option)) {
                        $optioncount = count($option);
                        for ($i = 0; $i < $optioncount; $i++) {

                            $t = 'table_column';
                            $t1 = $i + 1;
                            $iii = $t . $t1;
                            $optionrow = $option[$iii];
                        //    $this->WriteFileLog($optionrow);
                            $optionrowcount = count($optionrow);
                            for ($k = 0; $k < $optionrowcount-1; $k++) {
                                $t2 = 'row';
                                $t12 = $k + 1;
                                $iii2 = $t2 . $t12;
                                $optionrow2 = $optionrow[$iii2]; 
                                if (!empty($optionrow2)) {$this->WriteFileLog($optionrowcount);
                                    // $optionrowcount = count($optionrow);
                                    // for ($i = 0; $i < $optionrowcount; $i++) {
                                    $recommendation_detail_factors = DB::table('recommendation_detail_factors')->insertGetId([
                                        'recommendation_detail_area_id' => array_keys($optionrow)[0],
                                        'factor_name' => $optionrow2[1],
                                        'created_by' => auth()->user()->id,
                                        'created_at' => NOW()
                                    ]);
                                    DB::table('recommendation_report_detail2')->insertGetId([
                                        'reports_id' => $input['report_id'],
                                        'page_no' => $input['current_page'],
                                        'recommendation_detail_area_id' => array_keys($optionrow)[0],
                                        'recommendation_detail_factors_id' => $recommendation_detail_factors,
                                        'detail' => $optionrow2[2],
                                        'created_by' => auth()->user()->id,
                                        'created_at' => NOW()
                                    ]);
                                }
                            }
                        }
                    }
                }
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'pages' => $input['current_page'],
                        'status' => $input['btn_statu'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);
            } else {
                DB::table('reports')
                    ->where('reports_id', $input['report_id'])
                    ->update([
                        'status' => $input['btn_statu'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['report_id'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
}
