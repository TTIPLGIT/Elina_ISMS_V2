<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\sailassessmentreport;
use App\Mail\sailrecommendationreport;

class assessmentreportController extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => assessmentreportController => index';

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {

                $row = DB::table('reports_copy as a')
                    ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                    ->select('a.status as current_state', 'a.report_id', 'b.child_name', 'b.enrollment_child_num', 'a.republishCount')
                    ->whereIn('a.report_type', function ($query) {
                        $query->select('report_type')
                            ->from('reports_copy')
                            ->whereIn('report_type', function ($subquery) {
                                $subquery->select('reports_id')
                                    ->from('reports')
                                    ->where('report_type', 'SAIL')
                                    ->where('report_name', 'Assessment Report');
                            });
                    })
                    ->orderBy('a.report_id', 'desc')
                    ->get();
            } else {
                $row = DB::table('reports_copy as a')
                    ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                    ->select('a.status as current_state', 'a.report_id', 'b.child_name', 'b.enrollment_child_num', 'a.republishCount')
                    ->whereIn('a.report_type', function ($query) {
                        $query->select('report_type')
                            ->from('reports_copy')
                            ->whereIn('report_type', function ($subquery) {
                                $subquery->select('reports_id')
                                    ->from('reports')
                                    ->where('report_type', 'SAIL')
                                    ->where('report_name', 'Assessment Report');
                            });
                    })
                    ->whereIn('b.enrollment_child_num', function ($query) use ($authID) {
                        $query->select('enrollment_id')
                            ->from('sail_details')
                            ->where(function ($subquery) use ($authID) {
                                $subquery->whereRaw("JSON_EXTRACT(is_coordinator1, '$.id') = ?", [$authID])
                                    ->orWhereRaw("JSON_EXTRACT(is_coordinator2, '$.id') = ?", [$authID]);
                            });
                    })
                    ->orderBy('a.report_id', 'desc')
                    ->get();
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function report_list(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => report_list';
            $authID = auth()->user()->id;
            $row = DB::select("SELECT * FROM enrollment_details WHERE user_id = $authID");

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    //recommdation index

    public function index_data(Request $request)
    {
        try {

            $method = 'Method => assessmentreportController => index';

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $row = DB::select("select a.status AS current_state , a.report_id , b.child_name, b.enrollment_child_num , republishCount from reports_copy AS a 
                INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id WHERE report_type='9' ORDER BY a.report_id DESC ");
            } else {
                $row = DB::select("select a.status AS current_state , a.report_id , b.child_name, b.enrollment_child_num , republishCount from reports_copy AS a 
                INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id 
                WHERE report_type='9' AND b.enrollment_child_num IN (SELECT enrollment_id FROM sail_details WHERE (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID)) ORDER BY a.report_id DESC ");
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
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
        try {
            $method = 'Method => assessmentreportController => createdata';
            $reportsID = '7';
            $authID = auth()->user()->id;

            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $enrollment_details = DB::table('enrollment_details as a')
                    ->select('a.child_name', 'a.enrollment_child_num')
                    ->whereNotIn('a.enrollment_id', function ($query) use ($reportsID) {
                        $query->select('enrollment_id')
                            ->from('reports_copy')
                            ->where('report_type', $reportsID);
                    })
                    ->whereIn('a.enrollment_child_num', function ($query) {
                        $query->select('enrollment_child_num')
                            ->from('payment_status_details')
                            ->where('payment_for', 'SAIL Register Fee')
                            ->where('payment_status', 'SUCCESS');
                    })
                    ->orderByDesc('a.enrollment_id')
                    ->get();
            } else {
                $enrollment_details = DB::table('enrollment_details as a')
                    ->select('a.child_name', 'a.enrollment_child_num')
                    ->whereNotIn('a.enrollment_id', function ($query) use ($reportsID) {
                        $query->select('enrollment_id')
                            ->from('reports_copy')
                            ->where('report_type', $reportsID);
                    })
                    ->whereIn('a.enrollment_child_num', function ($query) {
                        $query->select('enrollment_child_num')
                            ->from('payment_status_details')
                            ->where('payment_for', 'SAIL Register Fee')
                            ->where('payment_status', 'SUCCESS');
                    })
                    ->whereIn('a.enrollment_child_num', function ($query) use ($authID) {
                        $query->select('enrollment_id')
                            ->from('sail_details')
                            ->where(function ($q) use ($authID) {
                                $q->whereRaw("JSON_EXTRACT(is_coordinator1, '$.id') = ?", [$authID])
                                    ->orWhereRaw("JSON_EXTRACT(is_coordinator2, '$.id') = ?", [$authID]);
                            });
                    })
                    ->orderByDesc('a.enrollment_id')
                    ->get();
            }

            $pages = DB::table('report_details')
                ->where('reports_id', $reportsID)
                ->where('enable_flag', 1)
                ->get();
            $page6 = DB::table('executive_functioning')
                ->where('report_id', $reportsID)
                ->get();
            $page8 = DB::table('sensory_profiling')
                ->where('report_id', $reportsID)
                ->get();

            $activitys = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity as c', 'c.skill_id', '=', 'b.skill_id')
                ->where('b.active_flag', 0)
                // ->where('c.isVerified', '!=', 1)
                ->select('a.*', 'b.*', 'c.*')
                ->get();
            $observations = DB::table('performance_skill_observation')->get();

            $perskill = DB::table('performance_skill')
                ->where('active_flag', 0)
                ->get();

            $subskill = DB::table('performance_sub_skill')->get();

            $response = [
                'enrollment_details' => $enrollment_details,
                'report' => $reportsID,
                'pages' => $pages,
                'page8' => $page8,
                'page6' => $page6,
                'activitys' => $activitys,
                'observations' => $observations,
                'perskill' => $perskill,
                'subskill' => $subskill,
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

    public function create_data()
    {
        try {
            $method = 'Method => assessmentreportController => createdata';
            $reportId = DB::table('reports')
                ->where('report_type', 'SAIL')
                ->where('report_name', 'recommendation report')
                ->where('active_flag', 0)
                ->value('reports_id');

            // Authenticated user info
            $authUser = auth()->user();
            $authUserId = $authUser->id;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));

            // Get role name
            $roleName = DB::table('uam_roles as ur')
                ->join('users as us', 'us.array_roles', '=', 'ur.role_id')
                ->where('us.id', $authUserId)
                ->value('role_name');

            // Build base enrollment query
            $enrollmentQuery = DB::table('enrollment_details as a')
                ->select('a.enrollment_id as enrollmentId', 'a.child_name', 'a.user_id', 'a.enrollment_child_num', 'a.enrollment_id')
                ->join('sail_details as b', 'a.enrollment_child_num', '=', 'b.enrollment_id')
                ->whereNotIn('a.enrollment_id', function ($subQuery) {
                    $subQuery->select('enrollment_id')
                        ->from('reports_copy')
                        ->whereIn('report_type', function ($inner) {
                            $inner->select('reports_id')
                                ->from('reports')
                                ->where('report_type', 'SAIL')
                                ->where('report_name', 'recommendation report');
                        });
                })
                ->whereIn('a.enrollment_child_num', function ($subQuery) {
                    $subQuery->select('enrollment_child_num')
                        ->from('payment_status_details')
                        ->where('payment_for', 'SAIL Register Fee')
                        ->where('payment_status', 'SUCCESS');
                });

            // Add coordinator condition if user is NOT role 4
            if (!in_array(4, $rolesArray)) {
                $enrollmentQuery->whereIn('a.enrollment_child_num', function ($subQuery) use ($authUserId) {
                    $subQuery->select('enrollment_id')
                        ->from('sail_details')
                        ->whereRaw("JSON_EXTRACT(is_coordinator1, '$.id') = ?", [$authUserId])
                        ->orWhereRaw("JSON_EXTRACT(is_coordinator2, '$.id') = ?", [$authUserId]);
                });
            }

            $enrollmentDetails = $enrollmentQuery->orderByDesc('a.enrollment_id')->get();

            // Report metadata
            $reportMeta = DB::table('reports')
                ->where('report_name', 'recommendation Report')
                ->first();

            $totalPages = $reportMeta->pages ?? 0;

            // Report pages
            $reportPages = DB::table('report_details')
                ->where('reports_id', $reportId)
                ->where('enable_flag', 1)
                ->orderBy('page')
                ->get();

            // Page 6: Area strengths
            $areaStrengths = DB::table('recommendation_report_detail1 as a')
                ->join('recommendation_detail_areas as b', 'a.recommendation_detail_area_id', '=', 'b.recommendation_detail_area_id')
                ->where('a.reports_id', $reportId)
                ->select('area_name', 'b.recommendation_detail_area_id', 'strengths')
                ->get();

            // Area Descriptions
            $areaDescriptions = DB::table('recommendation_area_discription as a')
                ->join('recommendation_detail_areas as b', 'a.recommendation_detail_area_id', '=', 'b.recommendation_detail_area_id')
                ->select('recommended_environment', 'b.recommendation_detail_area_id')
                ->get();

            // Page 7: Recommendations with factors
            $page7Details = DB::table('recommendation_report_detail2 as a')
                ->join('recommendation_detail_factors as b', 'a.recommendation_detail_factors_id', '=', 'b.recommendation_detail_factors_id')
                ->join('recommendation_detail_areas as c', 'b.recommendation_detail_area_id', '=', 'c.recommendation_detail_area_id')
                ->where('a.reports_id', $reportId)
                ->select('c.recommendation_detail_area_id', 'factor_name', 'recommendation_report_detail2_id', 'detail')
                ->get();

            // Page 7 Max: Count of factors per area
            $page7FactorCounts = DB::table('recommendation_report_detail2 as a')
                ->join('recommendation_detail_factors as b', 'a.recommendation_detail_factors_id', '=', 'b.recommendation_detail_factors_id')
                ->join('recommendation_detail_areas as c', 'b.recommendation_detail_area_id', '=', 'c.recommendation_detail_area_id')
                ->where('a.reports_id', $reportId)
                ->selectRaw('COUNT(a.recommendation_detail_area_id) as maxCount, a.recommendation_detail_area_id, c.area_name')
                ->groupBy('a.recommendation_detail_area_id', 'c.area_name')
                ->orderByDesc('maxCount')
                ->get();

            // Area List (Table 2)
            $areaList = DB::table('recommendation_detail_areas')
                ->where('table_num', '2')
                ->where('status', 0)
                ->select('recommendation_detail_area_id', 'area_name')
                ->get();

            // Component List (Table 3)
            $componentList = DB::table('recommendation_detail_areas')
                ->where('table_num', '3')
                ->where('status', 0)
                ->select('recommendation_detail_area_id', 'area_name')
                ->get();

            $tiers = DB::table('tiers')->get();

            foreach ($tiers as $tier) {
                // Initialize focus_areas as an empty array first
                $focusAreas = DB::table('focus_areas')
                    ->where('tier_id', $tier->id)
                    ->get();

                // foreach ($focusAreas as $focus) {
                //     $focus->detail = DB::table('focus_details')
                //         ->where('focus_area_id', $focus->id)
                //         ->first();
                // }

                // Assign the list of focus areas with their detail
                $tier->focus_areas = $focusAreas;
            }

            $response = [
                'enrollment_details' => $enrollmentDetails,
                'report' => $reportMeta,
                'pages' => $reportPages,
                'totalPage' => $totalPages,
                'page6' => $areaStrengths,
                'page7' => $page7Details,
                'areas' => $areaList,
                'description' => $areaDescriptions,
                'page7Max' => $page7FactorCounts[0]->maxCount ?? 0,
                'components' => $componentList,
                'tiers' => $tiers
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

    public function store_data(Request $request)
    {
        try {
            $method = 'Method => AssessmentreportController => store_data';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'state' => $inputArray['state'],
                'enrollmentId' => $inputArray['enrollmentId'],
                'meeting_description' => $inputArray['meeting_description'],
                'reports_id' => $inputArray['reports_id'],
                'rows' => $inputArray['rows'],
                'rows2' => $inputArray['rows2'],
                'evidence' => $inputArray['evidence'],
                'activity' => $inputArray['activity'],
                'observation' => $inputArray['observation'],
                'removedPages' => $inputArray['removedPages'],
                'switch' => $inputArray['switch'],
                'switch2' => $inputArray['switch2'],
                'dor' => $inputArray['dor'],
                'signature' => $inputArray['signature'],
                'sensory_recommendation' => $inputArray['rec_rows2'],
                'recommendation' => $inputArray['recommendation'],
                // 'flag' => $inputArray['switch_radio'],
            ];


            $report_id = DB::transaction(function () use ($input) {
                $page_header =  DB::table('reports_copy')
                    ->insertGetId([
                        'enrollment_id' => $input['enrollmentId'],
                        'report_type' => $input['reports_id'],
                        'status' => $input['state'],
                        'switch' => $input['switch'],
                        'switch2' => $input['switch2'],
                        'dor' => $input['dor'],
                        'signature' => json_encode($input['signature'], JSON_FORCE_OBJECT),
                    ]);

                $reportsID = $input['reports_id'];
                $meeting_description =  $input['meeting_description'];
                $removedPages =  $input['removedPages'];
                $option = DB::select("SELECT COUNT(*) AS c FROM report_details WHERE reports_id = $reportsID");

                foreach ($meeting_description as $key => $val) {
                    $ass_skill = DB::select(
                        "SELECT assesment_skill_id, tab_name FROM report_details WHERE page = ? AND reports_id = ?",
                        [$key, $reportsID]
                    );

                    DB::table('report_details_copy')->insertGetId([
                        'reports_id' => $page_header,
                        'page' => $key,
                        'page_description' => $val,
                        'assessment_skill' => $ass_skill[0]->assesment_skill_id,
                        'tab_name' => $ass_skill[0]->tab_name,
                        'enable_flag' => (in_array($key, $removedPages) ? '1' : null),
                        'page_description_copy' => html_entity_decode(strip_tags($val)),
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }

                $option = $input['rows'];
                if (!empty($option)) {
                    foreach ($option as $key => $value) {
                        DB::table('executive_functioning_copy')->insertGetId([
                            'report_id' => $page_header,
                            'page_no' => '6',
                            'executive_skills' => $value[1],
                            'strengths' => $value[2],
                            'stretches' => $value[3],
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                }
                $option = $input['rows2'];
                if (!empty($option)) {
                    DB::table('sensory_profiling_copy')->insertGetId([
                        'report_id' => $page_header,
                        'page_no' => '8',
                        'sensory_profiling1' => $option[1],
                        'sensory_profiling2' => $option[2],
                        'sensory_profiling3' => $option[3],
                        'sensory_profiling4' => $option[4],
                        'recommendation' => json_encode($input['sensory_recommendation'], JSON_UNESCAPED_UNICODE),
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }


                // $activity = $input['activity'] ?? [];
                // $observation = $input['observation'] ?? [];
                // $evidence = $input['evidence'] ?? [];
                // $recommendation = $input['recommendation'] ?? [];

                // $inputMap = [
                //     'activity' => [
                //         'data' => $activity,
                //         'table' => 'performance_skill_activity_final',
                //         'column' => 'activity_name',
                //     ],
                //     'observation' => [
                //         'data' => $observation,
                //         'table' => 'performance_skill_observation_final',
                //         'column' => 'observation_name',
                //     ],
                //     'evidence' => [
                //         'data' => $evidence,
                //         'table' => 'performance_skill_evidance_final',
                //         'column' => 'evidence',
                //     ],
                // ];

                // foreach ($inputMap as $type => $config) {
                //     $data = $config['data'];

                //     if (!empty($data)) {
                //         foreach ($data as $performance_area_id => $items) {
                //             $skill = DB::table('performance_skill')->where('performance_area_id', $performance_area_id)->first();
                //             if (!$skill) {
                //                 continue;
                //             }
                //             foreach ($items as $item) {
                //                 DB::table($config['table'])->insert([
                //                     'performance_area_id' => $performance_area_id,
                //                     $config['column'] => $item,
                //                     'skill_id' => $skill->skill_id,
                //                     'report_id' => $page_header
                //                 ]);
                //             }
                //         }
                //     }
                // }

                $activity = $input['activity'] ?? [];
                $observation = $input['observation'] ?? [];
                $evidence = $input['evidence'] ?? [];
                $recommendation = $input['recommendation'] ?? [];

                $inputMap = [
                    'activity' => [
                        'data' => $activity,
                        'table' => 'performance_skill_activity_final',
                        'column' => 'activity_name',
                    ],
                    'observation' => [
                        'data' => $observation,
                        'table' => 'performance_skill_observation_final',
                        'column' => 'observation_name',
                    ],
                    'evidence' => [
                        'data' => $evidence,
                        'table' => 'performance_skill_evidance_final',
                        'column' => 'evidence',
                        'recommendation' => $recommendation, // Include recommendation here
                    ],
                ];

                foreach ($inputMap as $type => $config) {
                    $data = $config['data'];

                    if (!empty($data)) {
                        foreach ($data as $performance_area_id => $items) {
                            $skill = DB::table('performance_skill')->where('performance_area_id', $performance_area_id)->first();
                            if (!$skill) {
                                continue;
                            }

                            foreach ($items as $index => $item) {
                                $insertData = [
                                    'performance_area_id' => $performance_area_id,
                                    $config['column'] => $item,
                                    'skill_id' => $skill->skill_id,
                                    'report_id' => $page_header,
                                ];

                                // If table is 'performance_skill_evidance_final', add recommendation if available
                                if ($config['table'] === 'performance_skill_evidance_final') {
                                    $rec = $config['recommendation'][$performance_area_id][$index] ?? null;
                                    if ($rec !== null) {
                                        $insertData['recommendation'] = $rec;
                                    }
                                }

                                DB::table($config['table'])->insert($insertData);
                            }
                        }
                    }
                }



                $reportId = $page_header;
                $createdBy = auth()->user()->id;
                $insertData = [];

                $skillTypeMap = [
                    'motor' => 1,
                    'skills' => 2,
                    'sub_skills' => 3,
                ];

                // foreach ($input['recommendation'] as $category => $skills) {
                //     $cleanCategory = trim($category, "'");
                //     $skillType = $skillTypeMap[$cleanCategory] ?? 0;
                //     foreach ($skills as $id => $skillName) {
                //         if ($skillName != null) {
                //             $insertData[] = [
                //                 'report_id'  => $reportId,
                //                 'skill_type' => $category,
                //                 'skill_type_id' => $skillType,
                //                 'skill_id' => $id,
                //                 'recommendation' => $skillName,
                //                 'created_by' => $createdBy,
                //                 'created_at' => now(),
                //             ];
                //         }
                //     }
                // }

                // DB::table('assessment_recommendation')->insert($insertData);

                if ($input['state'] == 'Saved') {
                    $eId = $input['enrollmentId'];
                    DB::table('sail_activity_vlog_comments')
                        ->where('enrollment_id', $eId)
                        ->update([
                            'assessment_flag' => 1,
                        ]);
                }
                if ($input['state'] == 'Submitted') {
                    $eId = $input['enrollmentId'];
                    $en = DB::select("SELECT child_name , enrollment_child_num FROM enrollment_details where enrollment_id = $eId");

                    $admin_details = DB::SELECT("SELECT id from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Report Create',
                                'notification_url' => 'report/assessmentreport/edit/' . encrypt($page_header),
                                'megcontent' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                                'alert_meg' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                    DB::table('sail_activity_vlog_comments')
                        ->where('enrollment_id', $eId)
                        ->update([
                            'assessment_flag' => 1,
                        ]);
                }

                return $page_header;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = '1';
            if ($input['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '0';
            }
            $serviceResponse['enrollmentId'] = $input['enrollmentId'];
            $serviceResponse['reports_id'] = $report_id;
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
        $method = 'Method => MasterAssessmentreportController => update_data';
        try {
            $decryptedInput = $this->DecryptData($request->requestData);
            $reportData = [
                'state' => $decryptedInput['state'],
                'enrollmentId' => $decryptedInput['enrollmentId'],
                'meetingDescriptions' => $decryptedInput['meeting_description'],
                'reportId' => $decryptedInput['reports_id'],
                'executiveFunctionRows' => $decryptedInput['rows'],
                'sensoryProfilingRows' => $decryptedInput['rows2'],
                'performanceEvidences' => $decryptedInput['evidence'],
                'performanceActivities' => $decryptedInput['activity'],
                'performanceObservations' => $decryptedInput['observation'],
                'removedPages' => $decryptedInput['removedPages'],
                'switch' => $decryptedInput['switch'],
                'switch2' => $decryptedInput['switch2'],
                'dateOfReport' => $decryptedInput['dor'],
                'signature' => $decryptedInput['signature'],
                'flagsJson' => $decryptedInput['switch_radio'],
                'sensoryRecommendation' => $decryptedInput['rec_rows2'],
                'recommendation' => $decryptedInput['recommendation'],
            ];

            DB::transaction(function () use ($reportData) {
                $reportStatus = $reportData['state'];
                $reportId = $reportData['reportId'];

                // Update the main report record
                DB::table('reports_copy')
                    ->where('report_id', $reportId)
                    ->update([
                        'status' => $reportStatus,
                        'switch' => $reportData['switch'],
                        'switch2' => $reportData['switch2'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                        'dor' => $reportData['dateOfReport'],
                        'signature' => json_encode($reportData['signature'], JSON_FORCE_OBJECT),
                    ]);

                // Get master report type ID
                $masterReportType = DB::select("SELECT report_type FROM reports_copy WHERE report_id = $reportId");
                $masterReportTypeId = $masterReportType[0]->report_type;

                $meetingDescriptions = $reportData['meetingDescriptions'];
                $removedPages = $reportData['removedPages'];

                // Delete old report details
                DB::table('report_details_copy')->where('reports_id', $reportId)->delete();

                // Insert updated report details
                foreach ($meetingDescriptions as $page => $description) {
                    $assessmentSkill = DB::select("SELECT assesment_skill_id, tab_name FROM report_details WHERE page = $page AND reports_id = $masterReportTypeId");
                    DB::table('report_details_copy')->insertGetId([
                        'reports_id' => $reportId,
                        'page' => $page,
                        'assessment_skill' => $assessmentSkill[0]->assesment_skill_id,
                        'tab_name' => $assessmentSkill[0]->tab_name,
                        'page_description_copy' => html_entity_decode(strip_tags($description)),
                        'enable_flag' => in_array($page, $removedPages) ? '1' : null,
                        'page_description' => $description,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW(),
                    ]);
                }

                // Update flags per page
                $flagsByPage = json_decode($reportData['flagsJson'], true);
                foreach ($flagsByPage as $page => $flag) {
                    DB::table('report_details_copy')
                        ->where('reports_id', $reportId)
                        ->where('page', $page)
                        ->update(['flag' => $flag]);
                }

                // Delete and insert executive functioning data
                DB::table('executive_functioning_copy')->where('report_id', $reportId)->delete();
                $executiveFunctionRows = $reportData['executiveFunctionRows'];
                if (!empty($executiveFunctionRows)) {
                    foreach ($executiveFunctionRows as $row) {
                        DB::table('executive_functioning_copy')->insertGetId([
                            'report_id' => $reportId,
                            'page_no' => '6',
                            'executive_skills' => $row[1],
                            'strengths' => $row[2],
                            'stretches' => $row[3],
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                }

                // Delete and insert sensory profiling data
                DB::table('sensory_profiling_copy')->where('report_id', $reportId)->delete();
                $sensoryProfilingRows = $reportData['sensoryProfilingRows'];
                if (!empty($sensoryProfilingRows)) {
                    DB::table('sensory_profiling_copy')->insertGetId([
                        'report_id' => $reportId,
                        'page_no' => '8',
                        'sensory_profiling1' => $sensoryProfilingRows[1],
                        'sensory_profiling2' => $sensoryProfilingRows[2],
                        'sensory_profiling3' => $sensoryProfilingRows[3],
                        'sensory_profiling4' => $sensoryProfilingRows[4],
                        'recommendation' => json_encode($reportData['sensoryRecommendation'], JSON_UNESCAPED_UNICODE),
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }

                // Performance activities
                $performanceActivities = $reportData['performanceActivities'];
                if (!empty($performanceActivities)) {
                    DB::table('performance_skill_activity_final')->where('report_id', $reportId)->delete();
                    foreach ($performanceActivities as $performanceAreaId => $activities) {
                        $skills = DB::select("SELECT skill_id FROM performance_skill WHERE performance_area_id = $performanceAreaId");
                        foreach ($activities as $activityName) {
                            DB::table('performance_skill_activity_final')->insertGetId([
                                'performance_area_id' => $performanceAreaId,
                                'activity_name' => $activityName,
                                'skill_id' => $skills[0]->skill_id,
                                'report_id' => $reportId
                            ]);
                        }
                    }
                }

                // Performance observations
                $performanceObservations = $reportData['performanceObservations'];
                if (!empty($performanceObservations)) {
                    DB::table('performance_skill_observation_final')->where('report_id', $reportId)->delete();
                    foreach ($performanceObservations as $performanceAreaId => $observations) {
                        $skills = DB::select("SELECT skill_id FROM performance_skill WHERE performance_area_id = $performanceAreaId");
                        foreach ($observations as $observationName) {
                            DB::table('performance_skill_observation_final')->insertGetId([
                                'performance_area_id' => $performanceAreaId,
                                'observation_name' => $observationName,
                                'skill_id' => $skills[0]->skill_id,
                                'report_id' => $reportId
                            ]);
                        }
                    }
                }

                // Performance evidences
                $performanceEvidences = $reportData['performanceEvidences'];
                if (!empty($performanceEvidences)) {
                    DB::table('performance_skill_evidance_final')->where('report_id', $reportId)->delete();
                    foreach ($performanceEvidences as $performanceAreaId => $evidences) {
                        $skills = DB::select("SELECT skill_id FROM performance_skill WHERE performance_area_id = $performanceAreaId");
                        foreach ($evidences as $index => $evidence) {
                            DB::table('performance_skill_evidance_final')->insertGetId([
                                'performance_area_id' => $performanceAreaId,
                                'evidence' => $evidence,
                                'skill_id' => $skills[0]->skill_id,
                                'report_id' => $reportId,
                                'recommendation' => $reportData['recommendation'][$performanceAreaId][$index] ?? null,
                            ]);
                        }
                    }
                }

                $reportId = $reportId;
                $createdBy = auth()->user()->id;
                $insertData = [];

                $skillTypeMap = [
                    'motor' => 1,
                    'skills' => 2,
                    'sub_skills' => 3,
                ];
                // foreach ($reportData['recommendation'] as $category => $skills) {
                //     $cleanCategory = trim($category, "'");
                //     $skillType = $skillTypeMap[$cleanCategory] ?? 0;
                //     foreach ($skills as $id => $skillName) {
                //         if ($skillName != null) {
                //             $insertData[] = [
                //                 'report_id'         => $reportId,
                //                 'skill_type'        => $category,
                //                 'skill_type_id'     => $skillType,
                //                 'skill_id'          => $id,
                //                 'recommendation'    => $skillName,
                //                 'created_by'        => $createdBy,
                //                 'created_at'        => now(),
                //             ];
                //         }
                //     }
                // }

                // DB::table('assessment_recommendation')->where('report_id', $reportId)->delete();
                // DB::table('assessment_recommendation')->insert($insertData);
                // If report status is 'Submitted', notify admins
                if ($reportStatus == 'Submitted') {
                    $enrollmentId = $reportData['enrollmentId'];
                    $enrollmentDetails = DB::select("SELECT child_name, enrollment_child_num FROM enrollment_details WHERE enrollment_id = $enrollmentId");

                    $adminUsers = DB::select("SELECT * FROM users WHERE array_roles = '4'");
                    $adminUserCount = count($adminUsers);
                    if ($adminUserCount > 0) {
                        for ($i = 0; $i < $adminUserCount; $i++) {
                            DB::table('notifications')->insertGetId([
                                'user_id' => $adminUsers[$i]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Report Create',
                                'notification_url' => 'report/assessmentreport/edit/' . encrypt($reportId),
                                'megcontent' => "Assessment Report for " . $enrollmentDetails[0]->child_name . " (" . $enrollmentDetails[0]->enrollment_child_num . " ) has been Submitted",
                                'alert_meg' => "Assessment Report for " . $enrollmentDetails[0]->child_name . " (" . $enrollmentDetails[0]->enrollment_child_num . " ) has been Submitted",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                }
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $this->GetReportData($reportData['reportId']);
            if ($reportData['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '1';
            }
            $serviceResponse['enrollmentId'] = $reportData['enrollmentId'];
            $serviceResponse['reports_id'] = $reportData['reportId'];
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

    public function report_update_data(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => report_update_data';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'state' => $inputArray['state'],
                'enrollmentId' => $inputArray['enrollmentId'],
                'meeting_description' => $inputArray['meeting_description'],
                'reports_id' => $inputArray['reports_id'],
                'rows' => $inputArray['rows'],
                'rows2' => $inputArray['rows2'],
                'components' => $inputArray['components'],
                'dor' => $inputArray['dor'],
                'signature' => $inputArray['signature'],
                'tiers' => $inputArray['tiers'],
            ];

            DB::transaction(function () use ($input) {

                $reports_id = $input['reports_id'];

                DB::table('reports_copy')
                    ->where('report_id', $input['reports_id'])
                    ->update([
                        'status' => $input['state'],
                        'dor' => $input['dor'],
                        'signature' => json_encode($input['signature'], JSON_FORCE_OBJECT),
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                    ]);

                $meeting_description =  $input['meeting_description'];
                $components = $input['components'];

                DB::table('report_details_copy')->where('reports_id', $reports_id)->delete();

                foreach ($meeting_description as $key => $val) {
                    DB::table('report_details_copy')->insertGetId([
                        'reports_id' => $input['reports_id'],
                        'page' => $key,
                        'page_description_copy' => html_entity_decode(strip_tags($val)),
                        'page_description' => $val,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);

                    if ($key == 3) {
                        DB::table('recommendation_report_detail1_final')->where('report_id', $reports_id)->delete();
                        $option = $input['rows'];
                        if (!empty($option)) {
                            $optioncount = count($option);
                            for ($i = 0; $i < $optioncount; $i++) {
                                $optionrow = $option["row" . ($i + 1)];
                                if (!empty($optionrow)) {
                                    $areaID = $optionrow[0];
                                    $rrdf1 = DB::select("SELECT recommendation_report_detail1_id FROM recommendation_report_detail1 AS a
                                    INNER JOIN recommendation_detail_areas AS b ON a.recommendation_detail_area_id=b.recommendation_detail_area_id
                                    WHERE b.recommendation_detail_area_id=$areaID");

                                    $o2 = !empty($optionrow[2]) ? implode('_', $optionrow[2]) : '';
                                    $o3 = !empty($optionrow[3]) ? implode('_', $optionrow[3]) : '';

                                    DB::table('recommendation_report_detail1_final')->insertGetId([
                                        'report_id' => $input['reports_id'],
                                        'recommendation_report_detail1_id' => $rrdf1[0]->recommendation_report_detail1_id,
                                        'strengths' => $optionrow[1],
                                        'recommended_enviroment' => $o2,
                                        'strategies_command' =>  $o3,
                                        'created_by' => auth()->user()->id,
                                        'created_at' => NOW()
                                    ]);
                                }
                            }
                        }
                    }

                    if ($key == 4) {
                        DB::table('recommendation_report_detail2_final')->where('report_id', $reports_id)->delete();
                        $option = $input['rows2'];
                        if (!empty($option)) {
                            $optioncount = count($option);
                            for ($i = 0; $i < $optioncount; $i++) {
                                $optionrow = $option["table_column" . ($i + 1)];
                                $optionrowcount = count($optionrow);
                                for ($k = 0; $k < $optionrowcount; $k++) {
                                    $optionrow2 = $optionrow["row" . ($k + 1)];
                                    if (!empty($optionrow2)) {
                                        DB::table('recommendation_report_detail2_final')->insertGetId([
                                            'report_id' => $input['reports_id'],
                                            'recommendation_report_detail2_id' => array_keys($optionrow2)[0],
                                            'detail' => $optionrow2[2],
                                            'created_by' => auth()->user()->id,
                                            'created_at' => NOW()
                                        ]);
                                    }
                                }
                            }
                        }
                    }

                    if ($key == 2) {
                        DB::table('recommendation_components_final')->where('report_id', $reports_id)->delete();
                        foreach ($components as $index => $component) {
                            DB::table('recommendation_components_final')->insertGetId([
                                'report_id' => $reports_id,
                                'recommendation_detail_area_id' => $index,
                                'description' => $component,
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                }

                // Tiers & Focus Areas
                foreach ($input['tiers'] as $tierId => $tierData) {
                    foreach ($tierData['focus_areas'] as $focusAreaId => $focusDetails) {
                        DB::table('focus_details')->updateOrInsert(
                            ['focus_area_id' => $focusAreaId, 'report_id' => $reports_id],
                            [
                                'key_strategies' => $focusDetails['key_strategies'],
                                'intended_outcomes' => $focusDetails['intended_outcomes'],
                                'updated_at' => now()
                            ]
                        );
                    }
                }

                if ($input['state'] == 'Submitted') {
                    $eId = $input['enrollmentId'];
                    $en = DB::select("SELECT * FROM enrollment_details where enrollment_id = $eId");

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Report Create',
                                'notification_url' => 'report/recommendation/edit/' . encrypt($reports_id),
                                'megcontent' => "Recommendation Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                                'alert_meg' => "Recommendation Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                }
            });


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = '1';
            if ($input['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '1';
            }
            $serviceResponse['enrollmentId'] = $input['enrollmentId'];
            $serviceResponse['reports_id'] = $input['reports_id'];
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
        //echo "naa";exit;
        try {
            $method = 'Method => assessmentreportController => createdata';
            $id = $this->DecryptData($id);
            $report = DB::table('reports_copy as a')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->select('b.child_contact_email', 'b.child_dob', 'b.enrollment_child_num', 'b.enrollment_id', 'b.child_name', 'b.child_id', 'a.dor', 'a.report_id', 'a.signature', 'a.switch', 'a.switch2', 'a.status')
                ->where('a.report_id', $id)
                ->first();

            $enrollmentId = $report->enrollment_id;

            $pages = DB::table('reports_copy as a')
                ->join('report_details_copy as b', 'a.report_id', '=', 'b.reports_id')
                ->select('b.page', 'b.page_description', 'b.enable_flag', 'b.assessment_skill', 'b.tab_name', 'a.status', 'b.flag')
                ->where('a.report_id', $id)
                ->get();

            $totalPage = $pages->count();

            $page8 = DB::table('sensory_profiling_copy')
                ->select('sensory_profiling1', 'sensory_profiling2', 'sensory_profiling3', 'sensory_profiling4', 'recommendation')
                ->where('report_id', $id)
                ->first();

            $activitys = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity as c', 'c.skill_id', '=', 'b.skill_id')
                ->select('c.skill_id', 'c.performance_area_id', 'b.skill_type', 'c.activity_id', 'c.activity_name', 'c.sub_skill', 'c.isVerified')
                ->where('b.active_flag', 0)
                ->get();

            $verifiedActivities = $activitys
                ->filter(function ($activity) {
                    return $activity->isVerified == 1;
                })
                ->pluck('activity_id')
                ->toArray();

            $observations = DB::table('performance_skill_observation')
                ->select('observation_id', 'observation_name')
                ->get();

            $details = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->select('b.skill_id', 'c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence', 'd.recommendation')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereNull('psa.sub_skill')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 1);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $details2 = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->join('performance_skill_activity as fpsa', 'fpsa.activity_id', '=', 'c.activity_name')
                ->select('fpsa.skill_id as cheSkill', 'b.skill_id', 'c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence', 'd.recommendation')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereNull('psa.sub_skill')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 2);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $details3 = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->select('c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence', 'd.recommendation')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 3);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $perskill = DB::table('performance_skill')
                ->select('performance_area_id', 'skill_type', 'skill_name', 'skill_id')
                ->where('active_flag', 0)
                ->get();

            $subskill = DB::table('performance_sub_skill')
                ->select('performance_area_id', 'primary_skill_id', 'skill_id', 'skill_name')
                ->get();

            $observation_act = DB::table('sail_activity_vlog_comments as sv')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'sv.activity_description_id')
                ->join('activity as ac', 'ac.activity_id', '=', 'sv.activity_id')
                ->join('users as u', 'u.id', '=', 'sv.created_by')
                ->join('enrollment_details as ed', 'ed.enrollment_id', '=', 'sv.enrollment_id')
                ->join('sail_details as sd', 'sd.enrollment_id', '=', 'ed.enrollment_child_num')
                ->select(
                    'sv.*',
                    'ad.description',
                    'ac.activity_name',
                    'u.name',
                    'ed.enrollment_child_num',
                    DB::raw("
                    CASE 
                        WHEN JSON_EXTRACT(sd.is_coordinator1, '$.id') = u.id THEN 'IS-Coordinator1'
                        WHEN JSON_EXTRACT(sd.is_coordinator2, '$.id') = u.id THEN 'IS-Coordinator2'
                        WHEN u.array_roles= 4 THEN 'IS-Head'
                    END AS user_display
                ")
                )
                ->where('sv.enrollment_id', $enrollmentId)
                ->where('sv.assessment_flag', 0)
                ->get();

            $report_flags = DB::table('report_details_copy')
                ->select('flag', 'page')
                ->where('reports_id', $id)
                ->get();

            $email = DB::table('email_preview')
                ->select('email_body')
                ->where('id', '14')
                ->get();

            $assessment_recommendation = DB::table('assessment_recommendation')
                ->select('recommendation', 'skill_type_id', 'skill_id')
                ->where('report_id', $id)
                ->get();

            $response = [
                'report' => $report,
                'pages' => $pages,
                'totalPage' => $totalPage,
                'page8' => $page8,
                'activitys' => $activitys,
                'observations' => $observations,
                'details' => $details,
                'details3' => $details3,
                'details2' => $details2,
                'perskill' => $perskill,
                'subskill' => $subskill,
                // 'subactivitys' => $subactivitys,
                'email' => $email[0]->email_body,
                'observation_act' => $observation_act,
                'reports_flag' => $report_flags,
                'assessment_recommendation' => $assessment_recommendation,
                'verifiedActivities' => $verifiedActivities
            ];
            $status = $pages[0]->status;
            if ($status == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '1';
            }
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

    public function recommendation_data_edit($id)
    {
        //echo "naa";exit;
        try {
            $method = 'Method => assessmentreportController => recommendation_data_edit';
            $id = $this->DecryptData($id);
            // $this->WriteFileLog($id);
            $report = DB::select("select * from reports_copy AS a 
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id WHERE a.report_id=$id");
            $pages = DB::select("SELECT * FROM reports_copy AS a 
            INNER JOIN report_details_copy AS b ON a.report_id=b.reports_id
            WHERE a.report_id=$id");
            $totalPage = count($pages);
            $page6 = DB::select("SELECT rrdf.* , a.recommendation_detail_area_id , b.area_name FROM recommendation_report_detail1_final AS rrdf 
            INNER JOIN recommendation_report_detail1 AS a ON a.recommendation_report_detail1_id=rrdf.recommendation_report_detail1_id
            INNER JOIN recommendation_detail_areas AS b ON a.recommendation_detail_area_id= b.recommendation_detail_area_id
            WHERE rrdf.report_id = $id");
            $page7 = DB::select("SELECT a.recommendation_detail_area_id, rrdf.detail , rrdf.recommendation_report_detail2_id , factor_name FROM recommendation_report_detail2_final AS rrdf 
            inner join recommendation_report_detail2 AS a ON rrdf.recommendation_report_detail2_id=a.recommendation_report_detail2_id
            INNER JOIN recommendation_detail_factors AS b
            INNER JOIN recommendation_detail_areas AS c ON 
            a.recommendation_detail_factors_id=b.recommendation_detail_factors_id AND 
            b.recommendation_detail_area_id=c.recommendation_detail_area_id
            WHERE rrdf.report_id = $id");
            $areas1 = DB::select("SELECT * from recommendation_detail_areas WHERE table_num ='1'");
            $areas = DB::select("SELECT * from recommendation_detail_areas WHERE table_num ='2'");
            $description = DB::select("SELECT * FROM recommendation_area_discription AS a
            INNER JOIN recommendation_detail_areas AS b ON a.recommendation_detail_area_id=b.recommendation_detail_area_id");
            $page7Max = DB::select("SELECT count(a.recommendation_detail_area_id) as maxc , a.recommendation_detail_area_id , c.area_name FROM recommendation_report_detail2_final AS rrdf 
            inner join recommendation_report_detail2 AS a ON rrdf.recommendation_report_detail2_id=a.recommendation_report_detail2_id
            INNER JOIN recommendation_detail_factors AS b ON  a.recommendation_detail_factors_id=b.recommendation_detail_factors_id
            INNER JOIN recommendation_detail_areas AS c ON b.recommendation_detail_area_id=c.recommendation_detail_area_id
            WHERE rrdf.report_id = $id GROUP BY a.recommendation_detail_area_id ORDER BY COUNT(a.recommendation_detail_area_id) DESC");
            $components = DB::select("SELECT a.recommendation_detail_area_id , area_name , description from recommendation_detail_areas AS a
            INNER JOIN recommendation_components_final AS b ON b.recommendation_detail_area_id = a.recommendation_detail_area_id
            WHERE report_id = $id");
            $email = DB::select("select * from email_preview where id = '15'");
            if (empty($components)) {
                $components = DB::select("SELECT recommendation_detail_area_id , area_name from recommendation_detail_areas WHERE table_num ='3' AND STATUS = 0");
            }

            $tiers = DB::table('tiers')->get();

            foreach ($tiers as $tier) {
                $focusAreas = DB::table('focus_areas')
                    ->where('tier_id', $tier->id)
                    ->get();

                foreach ($focusAreas as $focus) {
                    $focus->detail = DB::table('focus_details')
                        ->where('focus_area_id', $focus->id)
                        ->where('report_id', $id)
                        ->first();
                }

                $tier->focus_areas = $focusAreas;
            }

            $response = [
                'report' => $report,
                'pages' => $pages,
                'totalPage' => $totalPage,
                'page6' => $page6,
                'page7' => $page7,
                'areas' => $areas,
                'areas1' => $areas1,
                'description' => $description,
                'page7Max' => [],
                'components' => $components,
                'email' => $email[0]->email_body,
                'tiers' => $tiers
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

    public function sail_report_download(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => sail_report_download';
            $inputArray = $this->decryptData($request->requestData);
            $id = $inputArray['enrollmentId'];

            $ovm_report = $inputArray['ovm_report'];
            $enrollmentId = $inputArray['enrollmentId'];
            $Denial = $inputArray['Denial'];
            $Accept = $inputArray['Accept'];
            $email_content = $inputArray['email_content'];

            $getmail = DB::select("select * from enrollment_details WHERE enrollment_id='$id'");
            $data = array(
                'enrollmentId' => $id,
                'ovm_report' => $ovm_report,
                'child_name' => $getmail[0]->child_name,
                'accept' => $Accept,
                'denial' => $Denial,
                'email_content' => $email_content
            );
            $mail = $getmail[0]->child_contact_email;
            Mail::to($mail)->send(new sailassessmentreport($data));
            $getreport = DB::select("SELECT * FROM reports_copy WHERE enrollment_id = $id AND report_type = 9");
            DB::table('reports_copy')
                ->where('report_id', $getreport[0]->report_id)
                ->update([
                    'status' => 'Published',
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => NOW(),
                ]);

            // $this->WriteFileLog($getmail);
            $childGuardianName = $getmail[0]->child_father_guardian_name;
            DB::table('notifications')->insertGetId([
                'user_id' => $getmail[0]->user_id,
                'notification_type' => 'activity',
                'notification_status' => 'Sail',
                'notification_url' =>  $inputArray['notification'],
                'megcontent' => "SAIL Recommendation Report for " . $getmail[0]->child_name . " has been Generated.",
                'alert_meg' => "SAIL Recommendation Report for " . $getmail[0]->child_name . " has been Generated.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $this->sail_status_log('reports_copy', $getreport[0]->report_id, 'Recommendation Report Sent', 'Sail Status', auth()->user()->id, NOW(), $getmail[0]->enrollment_child_num);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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

    public function Recommendation_store_data(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => Recommendation_store_data  ';
            $decryptedData = $this->DecryptData($request->requestData);

            $input = [
                'state' => $decryptedData['state'],
                'enrollmentId' => $decryptedData['enrollmentId'],
                'meetingDescriptions' => $decryptedData['meeting_description'],
                'reportTypeId' => $decryptedData['reports_id'],
                //'recommendation_detail_area_id' => $decryptedData['recommendation_detail_area_id'],
                'recommendationRows1' => $decryptedData['rows'],
                'recommendationRows2' => $decryptedData['rows2'],
                'components' => $decryptedData['components'],
                'dateOfReport' => $decryptedData['dor'],
                'signature' => $decryptedData['signature'],
                'tiers' => $decryptedData['tiers'],
            ];

            $response = DB::transaction(function () use ($input) {
                // Insert into reports_copy table
                $reportId = DB::table('reports_copy')->insertGetId([
                    'enrollment_id' => $input['enrollmentId'],
                    'report_type' => $input['reportTypeId'],
                    'status' => $input['state'],
                    'dor' => $input['dateOfReport'],
                    'signature' => json_encode($input['signature'], JSON_FORCE_OBJECT),
                ]);

                $meetingDescriptions = $input['meetingDescriptions'];
                $components = $input['components'];
                $recommendationDetail1Map = DB::table('recommendation_report_detail1 as a')
                    ->join('recommendation_detail_areas as b', 'a.recommendation_detail_area_id', '=', 'b.recommendation_detail_area_id')
                    ->select('b.recommendation_detail_area_id', 'a.recommendation_report_detail1_id')
                    ->pluck('recommendation_report_detail1_id', 'recommendation_detail_area_id')
                    ->toArray();
                // Process each meeting description page
                foreach ($meetingDescriptions as $pageIndex => $description) {
                    $reportDetailId = DB::table('report_details_copy')->insertGetId([
                        'reports_id' => $reportId,
                        'page' => $pageIndex,
                        'page_description' => $description,
                        'page_description_copy' => html_entity_decode(strip_tags($description)),
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);

                    // Page 3 - Recommendation Report Detail 1 Final
                    if ($pageIndex == 3) {
                        $recommendationRows = $input['recommendationRows1'];
                        $batchInsertDetail1Final = [];

                        if (!empty($recommendationRows)) {
                            foreach ($recommendationRows as $rowData) {
                                $areaId = $rowData[0] ?? null;
                                if (!empty($areaId) && isset($recommendationDetail1Map[$areaId])) {
                                    $batchInsertDetail1Final[] = [
                                        'report_id' => $reportId,
                                        'recommendation_report_detail1_id' => $recommendationDetail1Map[$areaId],
                                        'strengths' => $rowData[1] ?? null,
                                        'recommended_enviroment' => !empty($rowData[2]) ? implode('_', $rowData[2]) : '',
                                        'strategies_command' => !empty($rowData[3]) ? implode('_', $rowData[3]) : '',
                                        'created_by' => auth()->user()->id,
                                        'created_at' => now(),
                                    ];
                                }
                            }
                            if (!empty($batchInsertDetail1Final)) {
                                DB::table('recommendation_report_detail1_final')->insert($batchInsertDetail1Final);
                            }
                        }
                    }

                    // Page 4 - Recommendation Report Detail 2 Final
                    if ($pageIndex == 4) {
                        $recommendationRows2 = $input['recommendationRows2'];
                        $batchInsertDetail2Final = [];

                        if (!empty($recommendationRows2)) {
                            foreach ($recommendationRows2 as $columnData) {
                                foreach ($columnData as $rowDetails) {
                                    if (!empty($rowDetails) && is_array($rowDetails)) {
                                        $keys = array_keys($rowDetails);
                                        $recommendation_report_detail2_id = $keys[0] ?? null;
                                        $detail = $rowDetails[2] ?? null;

                                        if ($recommendation_report_detail2_id !== null && $detail !== null) {
                                            $batchInsertDetail2Final[] = [
                                                'report_id' => $reportId,
                                                'recommendation_report_detail2_id' => $recommendation_report_detail2_id,
                                                'detail' => $detail,
                                                'created_by' => auth()->user()->id,
                                                'created_at' => now(),
                                            ];
                                        }
                                    }
                                }
                            }

                            if (!empty($batchInsertDetail2Final)) {
                                DB::table('recommendation_report_detail2_final')->insert($batchInsertDetail2Final);
                            }
                        }
                    }

                    // Page 2 - Components
                    if ($pageIndex == 2) {
                        $batchInsertComponents = [];
                        foreach ($components as $areaId => $componentDesc) {
                            $batchInsertComponents[] = [
                                'report_id' => $reportId,
                                'recommendation_detail_area_id' => $areaId,
                                'description' => $componentDesc,
                                'created_by' => auth()->user()->id,
                                'created_at' => now(),
                            ];
                        }
                        if (!empty($batchInsertComponents)) {
                            DB::table('recommendation_components_final')->insert($batchInsertComponents);
                        }
                    }
                }

                // Tiers & Focus Areas
                // foreach ($input['tiers'] as $tierId => $tierData) {
                //     foreach ($tierData['focus_areas'] as $focusAreaId => $focusDetails) {
                //         DB::table('focus_details')->updateOrInsert(
                //             ['focus_area_id' => $focusAreaId, 'report_id' => $reportId],
                //             [
                //                 'key_strategies' => $focusDetails['key_strategies'],
                //                 'intended_outcomes' => $focusDetails['intended_outcomes'],
                //                 'updated_at' => now()
                //             ]
                //         );
                //     }
                // }

                $records = [];

                foreach ($input['tiers'] as $tierId => $tierData) {
                    foreach ($tierData['focus_areas'] as $focusAreaId => $focusDetails) {
                        $records[] = [
                            'focus_area_id' => $focusAreaId,
                            'report_id' => $reportId,
                            'key_strategies' => $focusDetails['key_strategies'],
                            'intended_outcomes' => $focusDetails['intended_outcomes'],
                            'updated_at' => now(),
                        ];
                    }
                }

                DB::table('focus_details')->upsert(
                    $records,
                    ['focus_area_id', 'report_id'],
                    ['key_strategies', 'intended_outcomes', 'updated_at'] // Fields to update
                );


                // Notifications on Submit
                if ($input['state'] == 'Submitted') {
                    $enrollmentId = $input['enrollmentId'];
                    $enrollment = DB::select("SELECT child_name, enrollment_child_num FROM enrollment_details WHERE enrollment_id = ?", [$enrollmentId]);

                    $admins = DB::select("SELECT * FROM users WHERE array_roles = '4'");
                    foreach ($admins as $admin) {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $admin->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'Report Create',
                            'notification_url' => 'report/recommendation/edit/' . encrypt($reportId),
                            'megcontent' => "Recommendation Report for {$enrollment[0]->child_name} ({$enrollment[0]->enrollment_child_num}) has been Submitted",
                            'alert_meg' => "Recommendation Report for {$enrollment[0]->child_name} ({$enrollment[0]->enrollment_child_num}) has been Submitted",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }

                return $reportId;
            });


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = '1';
            if ($input['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '0';
            }
            $serviceResponse['enrollmentId'] = $input['enrollmentId'];
            $serviceResponse['reports_id'] = $response;
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

    public function area_ajax(Request $request)

    {
        $logMethod = 'Method => assessmentreportController => area_ajax';

        try {

            $inputArray = $request->requestData;

            $area_name = DB::select("SELECT * FROM recommendation_area_discription WHERE recommendation_detail_area_id = '$inputArray'");

            // $this->WriteFileLog($area_name);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $area_name;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
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
    public function sail_recommendation_download(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => sail_recommendation_download';
            // $this->WriteFileLog($method);
            $inputArray = $this->decryptData($request->requestData);
            $id = $inputArray['enrollmentId'];
            $ovm_report = $inputArray['ovm_report'];
            $ovm_report1 = $inputArray['ovm_report1'];
            $enrollmentId = $inputArray['enrollmentId'];
            $email_content = $inputArray['email_content'];
            $getmail = DB::select("select * from enrollment_details WHERE enrollment_id='$id'");
            $data = array(
                'enrollmentId' => $id,
                'ovm_report' => $ovm_report,
                'ovm_report1' => $ovm_report1,
                'child_name' => $getmail[0]->child_name,
                'email_content' => $email_content
            );
            $mail = $getmail[0]->child_contact_email;
            Mail::to($mail)->send(new sailrecommendationreport($data));
            $getreport = DB::select("SELECT * FROM reports_copy WHERE enrollment_id = $id AND report_type = 7");
            DB::table('reports_copy')
                ->where('report_id', $getreport[0]->report_id)
                ->update([
                    'status' => 'Published',
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => NOW(),
                ]);
            DB::table('notifications')->insertGetId([
                'user_id' => $getmail[0]->user_id,
                'notification_type' => 'activity',
                'notification_status' => 'Sail',
                'notification_url' =>  $inputArray['notification'],
                'megcontent' => "SAIL Assessment Report for " . $getmail[0]->child_name . " has been Generated.",
                'alert_meg' => "SAIL Assessment Report for " . $getmail[0]->child_name . " has been Generated.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $this->sail_status_log('reports_copy', $getreport[0]->report_id, 'Assessment Report Sent', 'Sail Status', auth()->user()->id, NOW(), $getmail[0]->enrollment_child_num);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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
    public function observation_view(Request $request)
    {
        //echo "naa";exit;
        try {

            $method = 'Method => assessmentreportController => observation_view';
            // $this->WriteFileLog($request->requestData);
            $inputArray = $this->decryptData($request->requestData);
            // $this->WriteFileLog($inputArray); // Add this line to log $inputArray

            $enrollmentId = $inputArray['enrollment_id'];
            // $this->WriteFileLog($enrollmentId);
            //$enrollmentId = $report[0]->enrollment_id;          
            $authID = auth()->user()->id;
            // $this->WriteFileLog($authID);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            $observation_act = DB::select("SELECT sv.*, ad.description, ac.activity_name, u.name, ed.enrollment_child_num,
             CASE 
              WHEN JSON_EXTRACT(sd.is_coordinator1, '$.id') = u.id THEN 'IS-Coordinator1'
              WHEN JSON_EXTRACT(sd.is_coordinator2, '$.id') = u.id THEN 'IS-Coordinator2'
              WHEN u.array_roles= 4 THEN 'IS-Head'
              END AS user_display
              FROM  sail_activity_vlog_comments AS sv 
             INNER JOIN activity_description AS ad ON ad.activity_description_id = sv.activity_description_id 
             INNER JOIN activity AS ac ON ac.activity_id = sv.activity_id 
             INNER JOIN users AS u ON u.id = sv.created_by
             INNER JOIN enrollment_details AS ed ON ed.enrollment_id = sv.enrollment_id
             INNER JOIN sail_details AS sd ON sd.enrollment_id = ed.enrollment_child_num  
             WHERE sv.enrollment_id = $enrollmentId AND sv.assessment_flag = 0;");
            $this->auditLog('sail_activity_vlog_comments', $observation_act[0]->enrollment_id, 'view', 'viewed the activity observation', $authID, NOW(), $role_name_fetch);

            // $this->WriteFileLog($observation_act);

            $response = [
                'observation_act' => $observation_act,
            ];
            // $this->WriteFileLog($response);
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
    public function meetingdes_updation(Request $request)
    {
        //echo "naa";exit;
        try {

            $method = 'Method => assessmentreportController => meetingdes_updation';

            $inputArray = $this->decryptData($request->requestData);

            $reports_id = $inputArray['reports_id'];
            $step_id = $inputArray['step_id'];
            $checking = $inputArray['checking'];

            $check_act = DB::table('report_details_copy')
                ->where('reports_id', $reports_id)
                ->where('page', $step_id)
                ->update([
                    'flag' => $checking,
                ]);
            $response = [
                'check_act' => $check_act,
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

    public function GetReportData($id)
    {
        $method = 'Method => assessmentreportController => createdata';
        try {

            $report = DB::table('reports_copy as a')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->select('b.child_contact_email', 'b.child_dob', 'b.enrollment_child_num', 'b.enrollment_id', 'b.child_name', 'b.child_id', 'a.dor', 'a.report_id', 'a.signature', 'a.switch', 'a.switch2', 'a.status')
                ->where('a.report_id', $id)
                ->first();

            $enrollmentId = $report->enrollment_id;

            $pages = DB::table('reports_copy as a')
                ->join('report_details_copy as b', 'a.report_id', '=', 'b.reports_id')
                ->select('b.page', 'b.page_description', 'b.enable_flag', 'b.assessment_skill', 'b.tab_name', 'a.status', 'b.flag')
                ->where('a.report_id', $id)
                ->get();

            $totalPage = $pages->count();

            $page8 = DB::table('sensory_profiling_copy')
                ->select('sensory_profiling1', 'sensory_profiling2', 'sensory_profiling3', 'sensory_profiling4')
                ->where('report_id', $id)
                ->first();

            $activitys = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity as c', 'c.skill_id', '=', 'b.skill_id')
                ->select('c.skill_id', 'c.performance_area_id', 'b.skill_type', 'c.activity_id', 'c.activity_name', 'c.sub_skill')
                ->where('b.active_flag', 0)
                ->get();

            $observations = DB::table('performance_skill_observation')
                ->select('observation_id', 'observation_name')
                ->get();

            $details = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->select('b.skill_id', 'c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereNull('psa.sub_skill')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 1);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $details2 = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->join('performance_skill_activity as fpsa', 'fpsa.activity_id', '=', 'c.activity_name')
                ->select('fpsa.skill_id as cheSkill', 'b.skill_id', 'c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereNull('psa.sub_skill')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 2);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $details3 = DB::table('assessment_skill as a')
                ->join('performance_skill as b', 'a.assessment_skill_id', '=', 'b.performance_area_id')
                ->join('performance_skill_activity_final as c', 'c.skill_id', '=', 'b.skill_id')
                ->join('performance_skill_observation_final as e', 'e.observation_id', '=', 'c.activity_id')
                ->join('performance_skill_evidance_final as d', 'd.evidance_id', '=', 'e.observation_id')
                ->select('c.activity_id', 'c.performance_area_id', 'c.activity_name', 'e.observation_name', 'd.evidence')
                ->whereIn('c.activity_name', function ($query) {
                    $query->select('psa.activity_id')
                        ->from('performance_skill_activity as psa')
                        ->whereIn('psa.skill_id', function ($subQuery) {
                            $subQuery->select('skill_id')
                                ->from('performance_skill')
                                ->where('skill_type', 3);
                        });
                })
                ->where('c.report_id', $id)
                ->where('b.active_flag', 0)
                ->get();

            $perskill = DB::table('performance_skill')
                ->select('performance_area_id', 'skill_type', 'skill_name', 'skill_id')
                ->where('active_flag', 0)
                ->get();

            $subskill = DB::table('performance_sub_skill')
                ->select('performance_area_id', 'primary_skill_id', 'skill_id', 'skill_name')
                ->get();

            $observation_act = DB::table('sail_activity_vlog_comments as sv')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'sv.activity_description_id')
                ->join('activity as ac', 'ac.activity_id', '=', 'sv.activity_id')
                ->join('users as u', 'u.id', '=', 'sv.created_by')
                ->join('enrollment_details as ed', 'ed.enrollment_id', '=', 'sv.enrollment_id')
                ->join('sail_details as sd', 'sd.enrollment_id', '=', 'ed.enrollment_child_num')
                ->select(
                    'sv.*',
                    'ad.description',
                    'ac.activity_name',
                    'u.name',
                    'ed.enrollment_child_num',
                    DB::raw("
                        CASE 
                            WHEN JSON_EXTRACT(sd.is_coordinator1, '$.id') = u.id THEN 'IS-Coordinator1'
                            WHEN JSON_EXTRACT(sd.is_coordinator2, '$.id') = u.id THEN 'IS-Coordinator2'
                            WHEN u.array_roles= 4 THEN 'IS-Head'
                        END AS user_display
                    ")
                )
                ->where('sv.enrollment_id', $enrollmentId)
                ->where('sv.assessment_flag', 0)
                ->get();

            $report_flags = DB::table('report_details_copy')
                ->select('flag', 'page')
                ->where('reports_id', $id)
                ->get();

            $email = DB::table('email_preview')
                ->select('email_body')
                ->where('id', '14')
                ->get();

            $response = [
                'report' => $report,
                'pages' => $pages,
                'totalPage' => $totalPage,
                'page8' => $page8,
                'activitys' => $activitys,
                'observations' => $observations,
                'details' => $details,
                'details3' => $details3,
                'details2' => $details2,
                'perskill' => $perskill,
                'subskill' => $subskill,
                // 'subactivitys' => $subactivitys,
                'email' => $email[0]->email_body,
                'observation_act' => $observation_act,
                'reports_flag' => $report_flags,
            ];
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            // $this->WriteFileLog('e-1');
            // $this->WriteFileLog($sendServiceResponse);
            return $this->EncryptData($sendServiceResponse);
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

    public function reportRepublish(Request $request)
    {
        $method = 'Method => assessmentreportController => reportRepublish';
        try {
            $inputArray = $this->decryptData($request->requestData);

            $reportID = $inputArray['reportID'];
            $comment = $inputArray['comment'];
            $type = $inputArray['type'];

            $reportDetails = DB::table('reports_copy')
                ->select('version', 'republishCount')
                ->where('report_id', $reportID)
                ->first();

            DB::table('reports_copy')
                ->where('report_id', $reportID)
                ->update([
                    'status' => 'Submitted',
                    'republishCount' => DB::raw('republishCount + 1'),
                ]);

            $newVersionNumber = $reportDetails->version + 1;

            $previousVersion = DB::table('reportversioncontrol')
                ->select('id')
                ->where('report_id', $reportID)
                ->orderBy('version_number', 'desc')
                ->first();

            $previousVersionId = $previousVersion ? $previousVersion->id : null;

            $version = DB::table('reportversioncontrol')
                ->insertGetId([
                    'version_number' => $newVersionNumber,
                    'report_id' => $reportID,
                    'report_type' => $type,
                    'change_description' => $comment,
                    'changed_by' => auth()->user()->id,
                    'prev_version_id' => $previousVersionId
                ]);

            DB::table('reports_copy')
                ->where('report_id', $reportID)
                ->update(['version' => $newVersionNumber]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = [
                'reportType' => $type,
                'reportID' => $this->EncryptData($reportID),
            ];
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

    public function getComment(Request $request)
    {
        $method = 'Method => assessmentreportController => getComment';
        try {
            $inputArray = $this->decryptData($request->requestData);

            $reportID = $inputArray['reportID'];
            $type = $inputArray['type'];

            $comments = $versions = DB::table('reportversioncontrol as rvc')
                ->join('users as us', 'us.id', '=', 'rvc.changed_by')
                ->select('rvc.version_number', 'rvc.change_description', 'rvc.change_date', 'us.name as changed_by')
                ->where('rvc.report_id', '=', $reportID)
                ->get();

            // $this->WriteFileLog($reportID);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $comments;
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
