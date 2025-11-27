<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homecontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $method = 'Method => homecontroller => index';

            $user_id = auth()->user()->id;
            // $expiration = session();
            // $this->WriteFileLog("expiration");
            // $this->WriteFileLog($expiration);
            $roles = auth()->user()->array_roles;
            $rolesArray = array_merge(array(auth()->user()->array_roles), explode(',', auth()->user()->roles));
            $users = DB::table('users')
                ->select('users.name', 'users.email', 'users.id', 'uam_roles.role_name', 'login_audit.login_time', 'users.profile_image', 'users.profile_path')
                ->rightjoin('uam_roles', 'uam_roles.role_id', '=', 'users.array_roles')
                ->rightjoin('login_audit', 'login_audit.user_id', '=', 'users.id')
                ->where('users.id', $user_id)
                ->orderBy('login_audit.audit_id', 'DESC')->first();

            if (in_array(4, $rolesArray)) {
                $chart1 =  DB::select("SELECT  (SELECT COUNT(*) FROM   enrollment_details ) AS child_enrollement_count,
                (SELECT COUNT(*) FROM   internship_application_form) AS internship_count,
                (SELECT COUNT(*) FROM   service_provider ) AS service_provider_count,
                (SELECT COUNT(*) FROM   school_enrollment_details) AS school_enrollment_count
                FROM dual");
            } else {
                $chart1 =  DB::select("SELECT  (SELECT COUNT(*) FROM enrollment_details WHERE enrollment_id IN (SELECT enrollment_id FROM ovm_allocation WHERE (is_coordinator1 = $user_id OR is_coordinator2 = $user_id)) ) AS child_enrollement_count,
                (SELECT COUNT(*) FROM   internship_application_form) AS internship_count,
                (SELECT COUNT(*) FROM   service_provider ) AS service_provider_count,
                (SELECT COUNT(*) FROM   school_enrollment_details) AS school_enrollment_count
                FROM DUAL");
            }

            $chart2 =  DB::select("SELECT YEAR as c_year, COALESCE(SUM(ovm_count), 0) AS ovm_count, COALESCE(SUM(sail_count), 0) AS sail_count,
                '0' AS dropped FROM ( SELECT EXTRACT(YEAR FROM created_date) AS year, COUNT(*) AS ovm_count, NULL AS sail_count
                FROM ovm_meeting_details GROUP BY EXTRACT(YEAR FROM created_date) 
                UNION ALL
                SELECT EXTRACT(YEAR FROM created_date) AS year, NULL AS ovm_count, COUNT(*) AS sail_count FROM sail_details 
                GROUP BY EXTRACT(YEAR FROM created_date) ) AS combined_counts WHERE YEAR IS NOT NULL 
                GROUP BY c_year ORDER BY c_year; ");
            if (in_array(4, $rolesArray)) {

                $userRow = DB::select("SELECT COUNT(*) as register_count FROM users WHERE array_roles = 3;");
                $ovm1Row = DB::select("SELECT COUNT(*) as ovm_count FROM ovm_meeting_details;");
                $ovm2Row = DB::select("SELECT COUNT(*) as ovm2_count FROM ovm_meeting_2_details;");

                $blackboard = [
                    (object) [
                        'child_enrollement_count' => $userRow[0]->register_count,
                        'ovm_count' => $ovm1Row[0]->ovm_count,
                        'ovm2_count' => $ovm2Row[0]->ovm2_count,
                        'sla_crossed' => '0', // You can set a default value or leave it out if not needed
                        'register_count' => $userRow[0]->register_count,
                    ],
                ];
            } else {
                // $blackboard =  DB::select("SELECT COUNT( distinct a.enrollment_child_num ) AS child_enrollement_count ,
                // COUNT( distinct b.ovm_meeting_id ) AS ovm_count , COUNT( distinct c.ovm_meeting_id ) AS ovm2_count ,'0' as sla_crossed ,COUNT( distinct d.id )AS register_count 
                // FROM enrollment_details as a CROSS JOIN ovm_meeting_details AS b CROSS JOIN ovm_meeting_2_details AS c CROSS JOIN users AS d
                // WHERE d.array_roles='3' AND a.enrollment_child_num IN (SELECT enrollment_id FROM ovm_meeting_details )
                // AND (JSON_EXTRACT(b.is_coordinator1 , '$.id') = $user_id OR JSON_EXTRACT(b.is_coordinator2 , '$.id') = $user_id) AND (JSON_EXTRACT(c.is_coordinator1 , '$.id') = $user_id OR 
                // JSON_EXTRACT(c.is_coordinator2 , '$.id') = $user_id) ");
                $userRow = DB::select("SELECT COUNT(*) as register_count FROM users WHERE array_roles = 3;");
                $ovm1Row = DB::select("SELECT COUNT(*) as ovm_count FROM ovm_meeting_details;");
                $ovm2Row = DB::select("SELECT COUNT(*) as ovm2_count FROM ovm_meeting_2_details;");

                $blackboard = [
                    (object) [
                        'child_enrollement_count' => $userRow[0]->register_count,
                        'ovm_count' => $ovm1Row[0]->ovm_count,
                        'ovm2_count' => $ovm2Row[0]->ovm2_count,
                        'sla_crossed' => '0', // You can set a default value or leave it out if not needed
                        'register_count' => $userRow[0]->register_count,
                    ],
                ];
            }
            if (in_array(4, $rolesArray)) {
                // Admin: Get latest login records per user
                $userlogin = DB::table('login_audit')
                    ->join('users', 'users.id', '=', 'login_audit.user_id')
                    ->join('uam_roles', 'uam_roles.role_id', '=', 'users.array_roles')
                    ->whereIn('login_audit.audit_id', function ($query) {
                        $query->select(DB::raw('MAX(audit_id)'))
                            ->from('login_audit')
                            ->groupBy('user_id');
                    })
                    ->select('login_audit.login_time', 'login_audit.logout_time', 'users.name', 'users.email', 'uam_roles.role_name')
                    ->orderByDesc('audit_id')
                    ->limit(10)
                    ->get();
            } else {
                // Non-admin: Only their login records
                $userlogin = DB::table('login_audit')
                    ->join('users', 'users.id', '=', 'login_audit.user_id')
                    ->join('uam_roles', 'uam_roles.role_id', '=', 'users.array_roles')
                    ->where('users.id', $user_id)
                    ->select('login_audit.login_time', 'login_audit.logout_time', 'users.name', 'users.email', 'uam_roles.role_name')
                    ->orderByDesc('audit_id')
                    ->limit(10)
                    ->get();
            }

            $sail = DB::table('sail_status_logs as a')
                ->join('sail_details as sd', 'a.enrollment_id', '=', 'sd.enrollment_id')
                ->join('enrollment_details as ed', 'ed.enrollment_child_num', '=', 'a.enrollment_id')
                ->join(DB::raw('(SELECT enrollment_id, MAX(id) AS max_date FROM sail_status_logs GROUP BY enrollment_id) as b'), function ($join) {
                    $join->on('a.enrollment_id', '=', 'b.enrollment_id')
                        ->on('a.id', '=', 'b.max_date');
                })
                ->select('a.audit_action', 'ed.child_name', 'ed.enrollment_child_num', 'sd.is_coordinator1')
                ->get();

            $dropped = []; // DB::select("SELECT * FROM enrollment_details AS a RIGHT JOIN elina_assessment AS b ON b.enrollment_id = a.enrollment_id WHERE b.dropped = 1");

            $elinalead = DB::table('enrollment_details')->count();

            if (in_array(4, $rolesArray)) {
                // Admin or full-access user
                $enrollment_details = DB::table('enrollment_details')
                    ->select('enrollment_child_num', 'child_name', 'child_contact_email', 'child_contact_phone', 'status', 'enrollment_id')
                    ->where('active_flag', 0)
                    ->orderByDesc('enrollment_id')
                    ->get();

                $report = DB::table('reports_copy')
                    ->select(DB::raw('COUNT(*) AS total'), 'report_type')
                    ->where('status', 'Published')
                    ->groupBy('report_type')
                    ->get();
            } else {
                // Restricted-access user
                $enrollment_details = DB::table('enrollment_details as a')
                    ->join('ovm_allocation as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                    ->select('a.enrollment_child_num', 'a.child_name', 'a.child_contact_email', 'a.child_contact_phone', 'a.status', 'a.enrollment_id')
                    ->where('a.active_flag', 0)
                    ->where(function ($query) use ($user_id) {
                        $query->where('b.is_coordinator1', $user_id)
                            ->orWhere('b.is_coordinator2', $user_id);
                    })
                    ->orderByDesc('a.enrollment_id')
                    ->get();

                $report = DB::table('reports_copy')
                    ->select(DB::raw('COUNT(*) AS total'), 'report_type')
                    ->where('status', 'Published')
                    ->whereIn('enrollment_id', function ($query) use ($user_id) {
                        $query->select('b.enrollment_id')
                            ->from('sail_details as a')
                            ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_child_num')
                            ->where(function ($subQuery) use ($user_id) {
                                $subQuery->where(DB::raw("JSON_EXTRACT(is_coordinator1, '$.id')"), $user_id)
                                    ->orWhere(DB::raw("JSON_EXTRACT(is_coordinator2, '$.id')"), $user_id);
                            });
                    })
                    ->groupBy('report_type')
                    ->get();
            }

            $coordinators = DB::table('users')
                ->select('id', 'name')
                ->where('array_roles', 5)
                ->where('active_flag', 0)
                ->where('delete_status', 0)
                ->get();

            $response = [
                'users' => $users,
                'chart1' => $chart1,
                'chart2' => $chart2,
                'userlogin' => $userlogin,
                'blackboard' => $blackboard,
                // 'ovm_meeting_details' => $ovm_meeting_details,
                'sail' => $sail,
                'dropped' => $dropped,
                'elinalead' => $elinalead,
                'enrollment_details' => $enrollment_details,
                'report' => $report,
                'coordinators' => $coordinators
            ];
            // $this->WriteFileLog($response);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $this->EncryptData($response);
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
    public function elinaleadsearch(Request $request)
    {
        $logMethod = 'Method => homecontroller => elinaleadsearch';

        try {

            $inputArray = $request->requestData;
            $this->WriteFileLog($inputArray);
            // $input = [
            // 	'enrollment_child_num' => $inputArray['enrollment_child_num'],


            // $this->WriteFileLog($input);
            $id = DB::select("SELECT b.payment_status,b.payment_for,a.* FROM enrollment_details AS a 
            left  JOIN payment_status_details AS b ON b.initiated_to=a.child_contact_email 
            WHERE b.payment_for='User Register Fee' $inputArray");
            $this->WriteFileLog($id);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $id;
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

    public function status_view(Request $request)
    {
        try {
            $method = 'Method => homecontroller => status_view';
            $input = $this->DecryptData($request[0]);
            // $this->WriteFileLog($input['get_type']);
            $get_type = $input['get_type'];
            $enrollment_id = $input['enrollment_id'];
            // $this->WriteFileLog($get_type);
            if ($get_type == 'ovm') {
                $rows = DB::select("SELECT a.audit_table_name , a.audit_action , ed.child_name , omd.is_coordinator1 , omd.is_coordinator2 , ed.enrollment_child_num , omd.meeting_startdate , omd.meeting_starttime
                FROM ovm_status_logs AS a INNER JOIN enrollment_details AS ed ON ed.enrollment_child_num=a.enrollment_id
                INNER JOIN ovm_meeting_details AS omd ON omd.enrollment_id = a.enrollment_id JOIN (SELECT enrollment_id, MAX(id) AS max_date
                FROM ovm_status_logs WHERE audit_table_name != 'in_person_meeting' GROUP BY enrollment_id ) AS b ON a.enrollment_id = b.enrollment_id AND a.id = b.max_date ;");
            } else if ($get_type == 'child') {
                $rows = [];
                $enrollment_details = DB::select("SELECT enrollment_child_num FROM enrollment_details WHERE enrollment_id = $enrollment_id");
                $enrollment_child_num = $enrollment_details[0]->enrollment_child_num;

                $students_logs = DB::select("SELECT b.* FROM enrollment_details AS a INNER JOIN students_logs AS b ON b.user_id = a.user_id WHERE a.active_flag = 0 AND a.enrollment_id=$enrollment_id");

                $payment = DB::select("SELECT CASE WHEN a.payment_status = 'success' THEN CONCAT(b.payment_for, ' Payment Completed')
                WHEN a.payment_status = 'new' THEN CONCAT(b.payment_for, ' Payment Initiated') ELSE CONCAT(b.payment_for, ' Payment ', a.payment_status)
                END AS description, a.created_date AS action_date_time FROM payment_process_details AS a
                INNER JOIN payment_status_details AS b ON a.enrollment_child_num = b.enrollment_child_num 
                WHERE b.enrollment_child_num = '$enrollment_child_num' GROUP BY a.payment_process_id;");

                $ovm = DB::select("SELECT CASE WHEN audit_table_name = 'ovm_meeting_details' THEN CONCAT('OVM 1 ', REPLACE(audit_action, 'OVM ', ''))
                WHEN audit_table_name = 'ovm_meeting_2_details' THEN CONCAT('OVM 2 ', REPLACE(audit_action, 'OVM ', ''))
                ELSE audit_action END AS description, action_date_time AS action_date_time
                FROM ovm_status_logs WHERE enrollment_id = '$enrollment_child_num';");

                $sail = DB::select("SELECT audit_action AS description , action_date_time AS action_date_time FROM sail_status_logs WHERE enrollment_id = '$enrollment_child_num'");

                foreach ($students_logs as $field_detail1) {
                    array_push($rows, $field_detail1);
                }

                foreach ($ovm as $field_detail2) {
                    array_push($rows, $field_detail2);
                }

                foreach ($payment as $field_detail3) {
                    array_push($rows, $field_detail3);
                }

                foreach ($sail as $field_detail4) {
                    array_push($rows, $field_detail4);
                }
                // $this->WriteFileLog('Here');
                // $this->WriteFileLog($rows);
                // usort($rows, function ($a, $b) {
                //     $dateTimeA = strtotime($a->action_date_time);
                //     $dateTimeB = strtotime($b->action_date_time);
                //     if (date("H:i:s", $dateTimeA) == "00:00:00") {
                //         $dateTimeA = strtotime($a->action_date_time . " 00:00:00");
                //     }
                //     if (date("H:i:s", $dateTimeB) == "00:00:00") {
                //         $dateTimeB = strtotime($b->action_date_time . " 00:00:00");
                //     }
                //     return ($dateTimeA > $dateTimeB) ? -1 : 1;
                // });

                // $this->WriteFileLog($rows);

                usort($rows, function ($a, $b) {
                    $dateTimeA = strtotime($a->action_date_time);
                    $dateTimeB = strtotime($b->action_date_time);

                    if ($dateTimeA === false && $dateTimeB === false) {
                        return 0;
                    } elseif ($dateTimeA === false) {
                        return 1;
                    } elseif ($dateTimeB === false) {
                        return -1;
                    }
                    return ($dateTimeA > $dateTimeB) ? -1 : 1;
                });

                // $this->WriteFileLog($rows);

                // usort($rows, function ($first, $second) {
                //     return $first->ovm_meeting_id < $second->ovm_meeting_id;
                // });

            } else if ($get_type == 'leads') {
                $rows = DB::select("SELECT '1' AS type_id , enrollment_id , child_name , enrollment_child_num, child_contact_email , child_contact_phone , created_date FROM enrollment_details WHERE STATUS = 'submitted'
                UNION 
                SELECT '2' AS type_id , id , NAME , unique_id , email_id , phone_no , create_at FROM webportal_may_help_you
                ORDER BY created_date DESC ");
            } else {
                $rows = DB::select("SELECT b.* FROM enrollment_details AS a
                INNER JOIN students_logs AS b ON b.user_id = a.user_id
                WHERE a.active_flag = 0 AND a.enrollment_id=$enrollment_id");
            }

            // $this->WriteFileLog($rows);
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

    public function searchCoordinators(Request $request)
    {
        try {
            $method = 'Method => homecontroller => status_view';
            $id = $this->DecryptData($request[0]);
            $this->WriteFileLog($id);
            $rows = DB::select("SELECT b.* FROM enrollment_details AS a
            INNER JOIN students_logs AS b ON b.user_id = a.user_id
            WHERE a.active_flag = 0 AND a.enrollment_id=$id");
            // $this->WriteFileLog($rows);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
