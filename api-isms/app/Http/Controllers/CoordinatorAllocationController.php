<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IS_AllocationMail;
use App\Mail\IS_ReallocationMail;
use App\Mail\IS_CancellationMail;
use App\Mail\OVMAllocationMail;
use App\Mail\OVMAllocationMail_IS;

class CoordinatorAllocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $method = 'Method => CoordinatorAllocationController => index';
            $authID = auth()->user()->id;
            $iscoordinators  = DB::select("SELECT * from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
            $this->WriteFileLog($iscoordinators);
            foreach ($iscoordinators as $coordinator) {
                $coordinator->ovm2_completion_count = DB::table('ovm_meeting_2_details')
                    ->where(function ($query) use ($coordinator) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.id")) = ?', [$coordinator->id])
                            ->orwhereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.id")) = ?', [$coordinator->id]);
                    })
                    ->where('meeting_status', 'Completed')
                    ->count();

                $ovm1_inprogress_count = DB::table('ovm_meeting_details')
                    ->join('enrollment_details AS e', 'ovm_meeting_details.enrollment_id', '=', 'e.enrollment_child_num')
                    ->select('ovm_meeting_details.enrollment_id', 'ovm_meeting_details.child_id', 'ovm_meeting_details.child_name', 'ovm_meeting_details.meeting_status')
                    ->addSelect(DB::raw("'OVM1' AS Type"))
                    ->where(function ($query) use ($coordinator) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.id")) = ?', [$coordinator->id])
                            ->orwhereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.id")) = ?', [$coordinator->id]);
                    })
                    // ->where('meeting_status', '!=', 'Completed')
                    ->groupBy('ovm_meeting_details.enrollment_id', 'ovm_meeting_details.child_name', 'ovm_meeting_details.meeting_status'); // Group by the aliases


                $ovm2_inprogress_count = DB::table('ovm_meeting_2_details')
                    ->join('enrollment_details AS e', 'ovm_meeting_2_details.enrollment_id', '=', 'e.enrollment_child_num')
                    ->select('ovm_meeting_2_details.enrollment_id', 'ovm_meeting_2_details.child_id', 'ovm_meeting_2_details.child_name', 'ovm_meeting_2_details.meeting_status')
                    ->addSelect(DB::raw("'OVM2' AS Type"))
                    ->where(function ($query) use ($coordinator) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.id")) = ?', [$coordinator->id])
                            ->orwhereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.id")) = ?', [$coordinator->id]);
                    })
                    ->where('meeting_status', '!=', 'Completed')
                    ->groupBy('ovm_meeting_2_details.enrollment_id', 'ovm_meeting_2_details.child_name', 'ovm_meeting_2_details.meeting_status'); // Group by the aliases


                $result = $ovm1_inprogress_count->union($ovm2_inprogress_count)->get();
                // Create an array to store the counts
                // $combinedResult = array_merge([
                //     'ovm1_inprogress_count' => $ovm1_inprogress_count,
                //     'ovm2_inprogress_count' => $ovm2_inprogress_count,
                // ], [
                //     'ovm2_inprogress_count' => $ovm2_inprogress_count,
                // ]);
                $coordinator->inprogress_count = $result;

                $coordinator->sail_inprogress_count = DB::table('sail_details AS s')
                    ->selectRaw('DISTINCT s.enrollment_id AS enrollment_id, s.child_name AS child_name, s.current_status AS current_status')
                    ->join('enrollment_details AS e', 's.enrollment_id', '=', 'e.enrollment_child_num')
                    ->join('activity_initiation AS a', 'a.enrollment_id', '=', 'e.enrollment_id')
                    ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(s.is_coordinator1, "$.id")) = ?', [$coordinator->id])
                    ->groupBy('s.enrollment_id', 's.child_name', 's.current_status', 's.id') // Group by the aliases
                    ->get();
            }
            $this->WriteFileLog($iscoordinators);
            $rows['enrollment_details'] = DB::select("SELECT a.enrollment_child_num , a.enrollment_id,a.child_name from enrollment_details as a
            right join payment_status_details on payment_status_details.enrollment_child_num = a.enrollment_child_num
            left join ovm_meeting_details on ovm_meeting_details.enrollment_id = a.enrollment_child_num
            where payment_status_details.payment_status = 'SUCCESS' 
            AND ovm_meeting_details.enrollment_id  IS null 
            AND a.enrollment_id NOT IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa WHERE oa.meeting_startdate !='00:00:00'AND oa.meeting_status !='Declined') ORDER BY a.enrollment_id DESC");


            $response = [
                'rows' => $iscoordinators,
                'rows1' => $rows,

            ];
            //$this->WriteFileLog($response);
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
    public function allocate_store(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $method = 'Method => CoordinatorAllocationController => allocate_store';
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'coordinator1_id' => $inputArray['coordinator1_id'],
                'coordinator2_id' => $inputArray['coordinator2_id'],
                'month' => $inputArray['month'],
                'weekDropdown' => $inputArray['weekDropdown'],

            ];
            DB::transaction(function () use ($input) {
                $settings_id = DB::table('ovm_allocation')
                    ->insertGetId([
                        'enrollment_id' => $input['enrollment_id'],
                        'child_id' => $input['child_id'],
                        'child_name' => $input['child_name'],
                        'is_coordinator1' => $input['coordinator1_id'],
                        'is_coordinator2' => $input['coordinator2_id'],
                        'status' => 1,
                        'month' => $input['month'],
                        'week' => $input['weekDropdown'],
                        'meeting_status' => "Allocated",
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);

                $this->auditLog('ovm_allocation', $settings_id, 'IS-Coordinator ALlocation', 'Allocate the IS-Coordinator', auth()->user()->id, NOW(), ' $role_name_fetch');
            });

            $enrollment_id = $input['enrollment_id'];
            $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");

            //$is_head = DB::select("Select * from users where id=$authID");
            DB::table('notifications')->insertGetId([
                'user_id' => $authID,
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'coordinator/list/view',
                'megcontent' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $child_dob = $enrollment[0]->child_dob;
            $parentname = $enrollment[0]->child_father_guardian_name;
            $child_email = $enrollment[0]->child_contact_email;
            $child_phoneno = $enrollment[0]->child_contact_phone;


            $isco1 = DB::select("Select * from users where id=" . $input['coordinator1_id']);
            DB::table('notifications')->insertGetId([
                'user_id' => $input['coordinator1_id'],
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'allocation/list',
                'megcontent' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $data = [
                'mailSubject' => 'IS-Coordinator Allocation',
                'child_name' => $input['child_name'],
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],
                'child_dob' => $child_dob,
                'parentname' => $parentname,
                'email' => $child_email,
                'contact_no' => $child_phoneno,
            ];
            $this->WriteFileLog("in");
            $this->WriteFileLog($isco1[0]->email);
            Mail::to($isco1[0]->email)->send(new IS_AllocationMail($data));
            $this->WriteFileLog("in1");

            $is2 = $input['coordinator2_id'];
            if ($is2 != 'Select-IS-Coordinator-2') {
                DB::table('notifications')->insertGetId([
                    'user_id' => $input['coordinator2_id'],
                    'notification_type' => 'OVM Meeting',
                    'notification_status' => 'OVM Meeting',
                    'notification_url' => 'allocation/list',
                    'megcontent' => "ISCoordinator-1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'alert_meg' => "ISCoordinator1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Allocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $isco2 = DB::select("Select * from users where id= $is2");
                $this->WriteFileLog("in2");
                $this->WriteFileLog($isco2[0]->email);
                Mail::to($isco2[0]->email)->send(new IS_AllocationMail($data));
                $this->WriteFileLog("in");
            }

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
    public function list(Request $request)
    {

        $method = 'Method => CoordinatorAllocationController => list';
        try {
            $rows = DB::select('SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o
            INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id
            INNER JOIN users AS u1 ON u1.id = o.is_coordinator1
            INNER JOIN users AS u2 ON u2.id = o.is_coordinator2
            WHERE o.STATUS !=""  ORDER BY o.id DESC');

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
    public function show(Request $request, $id)
    {
        $this->WriteFileLog("ds");
        $method = 'Method => CoordinatorAllocationController => show';

        try {

            $userID = auth()->user()->id;

            $this->WriteFileLog($id);

            $rows = DB::select("SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o
            INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id
            INNER JOIN users AS u1 ON u1.id = o.is_coordinator1
            INNER JOIN users AS u2 ON u2.id = o.is_coordinator2 WHERE o.id=$id");
            $this->WriteFileLog($rows);
            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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
    public function edit(Request $request, $id)
    {
        $this->WriteFileLog("ds");
        $method = 'Method => CoordinatorAllocationController => show';

        try {

            $userID = auth()->user()->id;

            $this->WriteFileLog($id);

            $rows = DB::select("SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o
            INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id
            INNER JOIN users AS u1 ON u1.id = o.is_coordinator1
            INNER JOIN users AS u2 ON u2.id = o.is_coordinator2 WHERE o.id=$id");

            $this->WriteFileLog($rows);

            $response = [
                'rows' => $rows,

            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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
    public function reallocation(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $method = 'Method => CoordinatorAllocationController => reallocation';
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'coordinator1_id' => $inputArray['coordinator1_id'],
                'coordinator2_id' => $inputArray['coordinator2_id'],
                'month' => $inputArray['month'],
                'weekDropdown' => $inputArray['weekDropdown'],
                'description' => $inputArray['description'],

            ];
            DB::transaction(function () use ($input) {
                $settings_id = DB::table('ovm_allocation')
                    ->where([['enrollment_id', $input['enrollment_id']]])
                    ->update([
                        'enrollment_id' => $input['enrollment_id'],
                        'child_id' => $input['child_id'],
                        'child_name' => $input['child_name'],
                        'is_coordinator1' => $input['coordinator1_id'],
                        'is_coordinator2' => $input['coordinator2_id'],
                        'status' => 2,
                        'month' => $input['month'],
                        'week' => $input['weekDropdown'],
                        'comments' => $input['description'],
                        'meeting_status' => "Reallocated",
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                $this->auditLog('ovm_allocation', $settings_id, 'IS-Coordinator Reallocation', 'Reallocate the IS-Coordinator', auth()->user()->id, NOW(), ' $role_name_fetch');
            });
            $enrollment_id = $input['enrollment_id'];
            $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");

            //$is_head = DB::select("Select * from users where id=$authID");
            DB::table('notifications')->insertGetId([
                'user_id' => $authID,
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'coordinator/list/view',
                'megcontent' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $child_dob = $enrollment[0]->child_dob;
            $parentname = $enrollment[0]->child_father_guardian_name;
            $child_email = $enrollment[0]->child_contact_email;
            $child_phoneno = $enrollment[0]->child_contact_phone;

            $isco1 = DB::select("Select * from users where id=" . $input['coordinator1_id']);
            DB::table('notifications')->insertGetId([
                'user_id' => $input['coordinator1_id'],
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'allocation/list',
                'megcontent' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $data = [
                'mailSubject' => 'IS-Coordinator Reallocation',
                'child_name' => $input['child_name'],
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],
                'child_dob' => $child_dob,
                'parentname' => $parentname,
                'email' => $child_email,
                'contact_no' => $child_phoneno,
            ];
            $this->WriteFileLog("in");
            $this->WriteFileLog($isco1[0]->email);
            Mail::to($isco1[0]->email)->send(new IS_ReallocationMail($data));
            $this->WriteFileLog("in1");

            $is2 = $input['coordinator2_id'];
            if ($is2 != 'Select-IS-Coordinator-2') {
                DB::table('notifications')->insertGetId([
                    'user_id' => $input['coordinator2_id'],
                    'notification_type' => 'OVM Meeting',
                    'notification_status' => 'OVM Meeting',
                    'notification_url' => 'allocation/list',
                    'megcontent' => "ISCoordinator-1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'alert_meg' => "ISCoordinator1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Reallocated for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $isco2 = DB::select("Select * from users where id= $is2");
                $this->WriteFileLog("in2");
                $this->WriteFileLog($isco2[0]->email);
                Mail::to($isco2[0]->email)->send(new IS_ReallocationMail($data));
                $this->WriteFileLog("in");
            }



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
    public function cancellation(Request $request, $id)
    {
        $this->WriteFileLog("ds");
        $method = 'Method => CoordinatorAllocationController => show';
        $id = $this->decryptData($id);
        try {

            $userID = auth()->user()->id;

            $this->WriteFileLog($id);

            $rows = DB::select("SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o
            INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id
            INNER JOIN users AS u1 ON u1.id = o.is_coordinator1
            INNER JOIN users AS u2 ON u2.id = o.is_coordinator2 WHERE o.id=$id");

            $this->WriteFileLog($rows);

            $response = [
                'rows' => $rows,

            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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
    public function cancellation_store(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $method = 'Method => CoordinatorAllocationController => cancellation_store';
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $hii = $role_name_fetch;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'coordinator1_id' => $inputArray['coordinator1_id'],
                'coordinator2_id' => $inputArray['coordinator2_id'],
                'month' => $inputArray['month'],
                'weekDropdown' => $inputArray['weekDropdown'],
                'description' => $inputArray['description'],

            ];
            DB::transaction(function () use ($input) {
                $settings_id = DB::table('ovm_allocation')
                    ->where([['enrollment_id', $input['enrollment_id']]])
                    ->update([
                        'enrollment_id' => $input['enrollment_id'],
                        'child_id' => $input['child_id'],
                        'child_name' => $input['child_name'],
                        'is_coordinator1' => $input['coordinator1_id'],
                        'is_coordinator2' => $input['coordinator2_id'],
                        'status' => 3,
                        'month' => $input['month'],
                        'week' => $input['weekDropdown'],
                        'comments' => $input['description'],
                        'meeting_status' => "Cancelled",
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                $this->auditLog('ovm_allocation', $settings_id, 'IS-Coordinator Cancellation', 'Cancel the IS-Coordinator', auth()->user()->id, NOW(), ' $role_name_fetch');
            });
            $enrollment_id = $input['enrollment_id'];
            $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");

            //$is_head = DB::select("Select * from users where id=$authID");
            DB::table('notifications')->insertGetId([
                'user_id' => $authID,
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'coordinator/list/view',
                'megcontent' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "ISCoordinator1-" . $inputArray['is_coordinator1'] . " and ISCoordinator2-" . $inputArray['is_coordinator2'] . " have been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $child_dob = $enrollment[0]->child_dob;
            $parentname = $enrollment[0]->child_father_guardian_name;
            $child_email = $enrollment[0]->child_contact_email;
            $child_phoneno = $enrollment[0]->child_contact_phone;

            $isco1 = DB::select("Select * from users where id=" . $input['coordinator1_id']);
            DB::table('notifications')->insertGetId([
                'user_id' => $input['coordinator1_id'],
                'notification_type' => 'OVM Meeting',
                'notification_status' => 'OVM Meeting',
                'notification_url' => 'allocation/list',
                'megcontent' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'alert_meg' => "You as ISCoordinator-1 and ISCoordinator-2 as " . $inputArray['is_coordinator2'] . " has been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $data = [
                'mailSubject' => 'IS-Coordinator Cancellation',
                'child_name' => $input['child_name'],
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],
                'child_dob' => $child_dob,
                'parentname' => $parentname,
                'email' => $child_email,
                'contact_no' => $child_phoneno,
            ];
            $this->WriteFileLog("in");
            $this->WriteFileLog($isco1[0]->email);
            Mail::to($isco1[0]->email)->send(new IS_CancellationMail($data));
            $this->WriteFileLog("in1");

            $is2 = $input['coordinator2_id'];
            if ($is2 != 'Select-IS-Coordinator-2') {
                DB::table('notifications')->insertGetId([
                    'user_id' => $input['coordinator2_id'],
                    'notification_type' => 'OVM Meeting',
                    'notification_status' => 'OVM Meeting',
                    'notification_url' => 'allocation/list',
                    'megcontent' => "ISCoordinator-1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'alert_meg' => "ISCoordinator1 as" . $inputArray['is_coordinator1'] . " and You as ISCoordinator-2 has been Cancelled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $isco2 = DB::select("Select * from users where id= $is2");
                $this->WriteFileLog("in2");
                $this->WriteFileLog($isco2[0]->email);
                Mail::to($isco2[0]->email)->send(new IS_CancellationMail($data));
                $this->WriteFileLog("in");
            }

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
    public function child_list(Request $request)
    {

        $method = 'Method => CoordinatorAllocationController => child_list';
        $authID = auth()->user()->id;
        try {
            $rows = DB::select('SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o
            INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id
            INNER JOIN users AS u1 ON u1.id = o.is_coordinator1
            INNER JOIN users AS u2 ON u2.id = o.is_coordinator2
            WHERE (o.meeting_startdate = "" and (o.is_coordinator1 = ? OR o.is_coordinator2 = ?)) 
                OR (o.meeting_enddate is Null and (o.is_coordinator1 = ? OR o.is_coordinator2 = ?))
            ORDER BY o.id DESC ', [$authID, $authID, $authID, $authID]);

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
    public function meetinginvite(Request $request)
    {
        $this->WriteFileLog("bhj");

        $this->WriteFileLog($request);


        try {
            $method = 'Method => CoordinatorAllocationController => meetinginvite';
            $rows = array();

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;

            $rows['enrollment_details'] = DB::select("Select a.enrollment_child_num , a.enrollment_id,a.child_name from enrollment_details as a
            right join payment_status_details on payment_status_details.enrollment_child_num = a.enrollment_child_num
            left join ovm_meeting_details on ovm_meeting_details.enrollment_id = a.enrollment_child_num
            where payment_status_details.payment_status = 'SUCCESS' 
            AND ovm_meeting_details.enrollment_id  IS null 
            AND a.enrollment_id NOT IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa) ORDER BY a.enrollment_id DESC");

            $rows['iscoordinators'] = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
            $this->WriteFileLog($rows);
            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Initiate' AND active_flag = 0");
            $email_allocation = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation' AND active_flag = 0");
            $users = DB::select("SELECT * FROM users WHERE array_roles != 3");
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $allocation_details = DB::select("SELECT o.*,e.user_id from ovm_allocation as o inner join enrollment_details AS e ON o.enrollment_id=e.enrollment_id WHERE o.id =$id");
            $response = [
                'rows' => $rows,
                'email' => $email,
                'users' => $users,
                'email_allocation' => $email_allocation,
                'allocation_details' => $allocation_details
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
    public function ovm_fetch(Request $request)
    {

        $method = 'Method => CoordinatorAllocationController =>ovm_fetch';
        try {

            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],

            ];
            $this->WriteFileLog($input);
            $id = $input['id'];


            $rows = DB::select("SELECT * from ovm_allocation where id =  $id ");

            $this->WriteFileLog($rows);

            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
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
    public function ovm_store(Request $request)
    {
        try {
            $method = 'Method => CoordinatorAllocationController => ovm_store';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],
                'is_coordinator1id' => $inputArray['is_coordinator1id'],
                'is_coordinator2id' => $inputArray['is_coordinator2id'],
                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],
                'meeting_location' => $inputArray['meeting_location'],

                'meeting_startdate2' => $inputArray['meeting_startdate2'],
                'meeting_enddate2' => $inputArray['meeting_enddate2'],
                'meeting_starttime2' => $inputArray['meeting_starttime2'],
                'meeting_endtime2' => $inputArray['meeting_endtime2'],
                'meeting_location2' => $inputArray['meeting_location2'],
                'url' => $inputArray['url'],
                'meeting_description' => $inputArray['meeting_description'],

                'meeting_status' => $inputArray['meeting_status'],
            ];

            DB::transaction(function () use ($input) {
                $ovm_meeting = DB::table('ovm_allocation')
                    ->where('enrollment_id', $input['enrollment_id'])
                    ->update([
                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_enddate' => $input['meeting_enddate'],
                        'meeting_starttime' => $input['meeting_starttime'],
                        'meeting_endtime' => $input['meeting_endtime'],
                        'meeting_location' => $input['meeting_location'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_enddate2' => $input['meeting_enddate2'],
                        'meeting_starttime2' => $input['meeting_starttime2'],
                        'meeting_endtime2' => $input['meeting_endtime2'],
                        'meeting_location2' => $input['meeting_location2'],
                        'meeting_status' => $input['meeting_status'],
                    ]);

                $meeting_status = $input['meeting_status'];
                if ($meeting_status == 'Sent') {
                    $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment_id = $input['enrollment_id'];
                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($ovm_meeting),
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'Overview Meeting Schedule and Confirmation',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),

                    ];

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMail($data));

                    $isco1 = DB::select("Select * from users where id=" . $input['is_coordinator1id']);
                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1id'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    Mail::to($isco1[0]->email)->bcc($bccRecipients)->send(new OVMAllocationMail_IS($data));
                    $is2 =  $input['is_coordinator2id'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $input['is_coordinator2id'],
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                            'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id=" .  $input['is_coordinator2id']);
                        Mail::to($isco2[0]->email)->bcc($bccRecipients)->send(new OVMAllocationMail_IS($data));
                    }
                }
            });


            // DB::transaction(function () use ($input) {

            //     $ovm_meeting = DB::table('ovm_allocation')
            //         ->insertGetId([
            //             'enrollment_id' => $input['enrollment_id'],
            //             'child_id' => $input['child_id'],
            //             'is_coordinator1' => $input['is_coordinator1'],
            //             'is_coordinator2' => $input['is_coordinator2'],
            //             'child_name' => $input['child_name'],
            //             'meeting_startdate' => $input['meeting_startdate'],
            //             'meeting_enddate' => $input['meeting_enddate'],
            //             'meeting_starttime' => $input['meeting_starttime'],
            //             'meeting_endtime' => $input['meeting_endtime'],
            //             'meeting_location' => $input['meeting_location'],

            //             'meeting_startdate2' => $input['meeting_startdate2'],
            //             'meeting_enddate2' => $input['meeting_enddate2'],
            //             'meeting_starttime2' => $input['meeting_starttime2'],
            //             'meeting_endtime2' => $input['meeting_endtime2'],
            //             'meeting_location2' => $input['meeting_location2'],

            //             'meeting_status' => $input['meeting_status'],

            //             'created_by' => auth()->user()->id,
            //             'created_date' => now(),
            //         ]);

            //     $meeting_status = $input['meeting_status'];
            //     if ($meeting_status == 'Sent') {
            //         $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

            //         $enrollment_id = $input['enrollment_id'];
            //         $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");
            //         DB::table('notifications')->insertGetId([
            //             'user_id' => $enrollment[0]->user_id,
            //             'notification_type' => 'OVM Meeting Scheduled',
            //             'notification_status' => 'OVM Meeting',
            //             'notification_url' => 'ovm_allocation/accept/' . encrypt($ovm_meeting),
            //             'megcontent' => "OVM Meeting has been Allocated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
            //             'alert_meg' => "OVM Meeting has been Allocated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
            //             'created_by' => auth()->user()->id,
            //             'created_at' => NOW()
            //         ]);
            //         $data = [
            //             'url' => $input['url'],
            //             'meeting_description' => $input['meeting_description'],
            //             'mailSubject' => 'Overview Meeting Schedule and Confirmation',
            //             'child_name' => $input['child_name'],

            //             'meeting_startdate' => $input['meeting_startdate'],
            //             'meeting_startdate2' => $input['meeting_startdate2'],
            //             'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
            //             'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
            //             'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
            //             'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),

            //         ];

            //         Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMail($data));

            //         $isco1 = DB::select("Select * from users where id=" . $input['is_coordinator1']);
            //         DB::table('notifications')->insertGetId([
            //             'user_id' => $input['is_coordinator1'],
            //             'notification_type' => 'OVM Meeting Scheduled',
            //             'notification_status' => 'OVM Meeting',
            //             'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
            //             'megcontent' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //             'alert_meg' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //             'created_by' => auth()->user()->id,
            //             'created_at' => NOW()
            //         ]);
            //         $bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
            //         Mail::to($isco1[0]->email)->bcc($bccRecipients)->send(new OVMAllocationMail_IS($data));
            //         $is2 = $input['is_coordinator2'];
            //         if ($is2 != 'Select-IS-Coordinator-2') {
            //             DB::table('notifications')->insertGetId([
            //                 'user_id' => $input['is_coordinator2'],
            //                 'notification_type' => 'OVM Meeting Scheduled',
            //                 'notification_status' => 'OVM Meeting',
            //                 'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
            //                 'megcontent' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //                 'alert_meg' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //                 'created_by' => auth()->user()->id,
            //                 'created_at' => NOW()
            //             ]);
            //             $isco2 = DB::select("Select * from users where id=" . $input['is_coordinator2']);
            //             Mail::to($isco2[0]->email)->bcc($bccRecipients)->send(new OVMAllocationMail_IS($data));
            //         }
            //     }
            // });

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

    public function date_validation(Request $request)
    {
        $this->WriteFileLog("ds");
        $method = 'Method => CoordinatorAllocationController => date_validation';
        $inputArray = $request->requestData;
        $this->WriteFileLog($inputArray);
        try {

            $userID = auth()->user()->id;

            $this->WriteFileLog($inputArray);

            $input = [
                'meeting_startdate1' => $inputArray['meeting_startdate1'],
                'meeting_starttime1' => $inputArray['meeting_starttime1'],
                'meeting_endtime1' => $inputArray['meeting_endtime1'],
                'meeting_startdate2' => $inputArray['meeting_startdate2'],
                'meeting_starttime2' => $inputArray['meeting_starttime2'],
                'meeting_endtime2' => $inputArray['meeting_endtime2'],
                'is_coo1' => $inputArray['is_coo1'],
                'is_coo2' => $inputArray['is_coo2'],
                'enrollment_id' => $inputArray['enrollment_id'],
            ];
            $startdate1 = $input['meeting_startdate1'];
            $starttime1 = $input['meeting_starttime1'];
            $endtime1 = $input['meeting_endtime1'];
            $startdate2 = $input['meeting_startdate2'];
            $starttime2 = $input['meeting_starttime2'];
            $endtime2 = $input['meeting_endtime2'];
            $coo1 = $input['is_coo1'];
            $coo2 = $input['is_coo2'];
            $enrollment_id = $input['enrollment_id'];

            $rows = DB::select("SELECT * from ovm_allocation where ((is_coordinator1='$coo1' AND meeting_startdate='$startdate1' and meeting_starttime BETWEEN '$starttime1' and '$endtime1' and meeting_endtime BETWEEN '$starttime1' and '$endtime1') or (is_coordinator2='$coo2' AND meeting_startdate2='$startdate2' and meeting_starttime2 BETWEEN '$starttime2' and '$endtime2' and meeting_endtime2 BETWEEN '$starttime2' and '$endtime2')) and enrollment_id !=$enrollment_id");
            $this->WriteFileLog($rows);
            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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
    public function calendar_list()
    {
        try {
            $method = 'Method => CoordinatorAllocationController => calendar_list';
            $authID = auth()->user()->id;
            $this->WriteFileLog($authID);

            $role_name = DB::select("SELECT ur.role_name,ur.role_id FROM uam_roles AS ur INNER JOIN users as us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_id = $role_name[0]->role_id;
            if ($role_id == 4) {
                $iscoordinators  = DB::select("SELECT * from users right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
                $this->WriteFileLog($iscoordinators);
                foreach ($iscoordinators as $coordinator) {
                    $coordinator->ovm2_completion_count = DB::table('ovm_meeting_2_details')
                        ->selectRaw('enrollment_id AS enrollment_id,child_name AS child_name,meeting_status AS meeting_status,meeting_startdate,meeting_enddate,meeting_starttime,meeting_endtime,meeting_description,
                        JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.name")) AS name1,
            JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.name")) AS name2,"OVM-2" AS type');


                    $ovm2 = $coordinator->ovm2_completion_count;

                    $coordinator->ovm1_completion_count = DB::table('ovm_meeting_details')
                        ->selectRaw('enrollment_id AS enrollment_id,child_name AS child_name,meeting_status AS meeting_status,meeting_startdate,meeting_enddate,meeting_starttime,meeting_endtime,meeting_description,
                        JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.name")) AS name1,
            JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.name")) AS name2,"OVM-1" AS type');


                    $ovm1 = $coordinator->ovm1_completion_count;

                    // Merge the results of ovm1 and ovm2 into a single array
                    $mergedResults = array_merge($ovm1->get()->toArray(), $ovm2->get()->toArray());


                    $coordinator->inprogress_count = $mergedResults;
                }
            } else {
                $iscoordinators  = DB::select("SELECT * from users right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0 and users.id=$authID");
                $this->WriteFileLog($iscoordinators);
                foreach ($iscoordinators as $coordinator) {
                    $coordinator->ovm2_completion_count = DB::table('ovm_meeting_2_details')
                        ->selectRaw('enrollment_id AS enrollment_id,child_name AS child_name,meeting_status AS meeting_status,meeting_startdate,meeting_enddate,meeting_starttime,meeting_endtime,meeting_description,
                        JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.name")) AS name1,
            JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.name")) AS name2,"OVM-2" AS type')

                        ->where(function ($query) use ($coordinator) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.id")) = ?', [$coordinator->id])
                                ->orwhereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.id")) = ?', [$coordinator->id]);
                        });

                    $ovm2 = $coordinator->ovm2_completion_count;

                    $coordinator->ovm1_completion_count = DB::table('ovm_meeting_details')
                        ->selectRaw('enrollment_id AS enrollment_id,child_name AS child_name,meeting_status AS meeting_status,meeting_startdate,meeting_enddate,meeting_starttime,meeting_endtime,meeting_description,
                        JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.name")) AS name1,
            JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.name")) AS name2,"OVM-1" AS type')
                        ->where(function ($query) use ($coordinator) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator1, "$.id")) = ?', [$coordinator->id])
                                ->orwhereRaw('JSON_UNQUOTE(JSON_EXTRACT(is_coordinator2, "$.id")) = ?', [$coordinator->id]);
                        });


                    $ovm1 = $coordinator->ovm1_completion_count;

                    // Merge the results of ovm1 and ovm2 into a single array
                    $mergedResults = array_merge($ovm1->get()->toArray(), $ovm2->get()->toArray());


                    $coordinator->inprogress_count = $mergedResults;
                }
            }

            // $this->WriteFileLog($iscoordinators);
            // $rows['enrollment_details'] = DB::select("Select a.enrollment_child_num , a.enrollment_id,a.child_name from enrollment_details as a
            // right join payment_status_details on payment_status_details.enrollment_child_num = a.enrollment_child_num
            // left join ovm_meeting_details on ovm_meeting_details.enrollment_id = a.enrollment_child_num
            // where payment_status_details.payment_status = 'SUCCESS' 
            // AND ovm_meeting_details.enrollment_id  IS null 
            // AND a.enrollment_id NOT IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa) ORDER BY a.enrollment_id DESC");

            $response = [
                'rows' => $iscoordinators,


            ];
            //$this->WriteFileLog($response);
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
}
