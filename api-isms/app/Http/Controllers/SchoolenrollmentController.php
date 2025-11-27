<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Mail;
use App\Jobs\schoolmailjob;
use App\Jobs\schooladminmailjob;
use App\Mail\schoolenrollmail;
use App\Mail\schooladminenrollmail;
use Illuminate\Support\Str;

class SchoolenrollmentController extends BaseController
{
    //
    public function index(Request $request)
    {
        try {

            $method = 'Method => SchoolenrollmentController => index';

            $rows = DB::select("SELECT * FROM school_enrollment_details 
            ORDER BY school_enrollment_id DESC ");

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

    public function createdata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => SchoolenrollmentController => createdata';

            $this->WriteFileLog($method);
            $rows = DB::select('select * from school_enrollment_details');


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


    public function storedata(Request $request)
    {

        //return $request;
        try {
            $method = 'Method => SchoolenrollmentController => storedata';


            // $this->WriteFileLog($method); 
            $inputArray = $request;

            $email = $inputArray['school_email'];
            $claimdetails = DB::table('school_enrollment_details')
                ->where('school_email', '=', $inputArray['school_email'])
                ->get()
                ->toArray();
            $react_web = isset($request->react_web)?$request->react_web:FALSE;
            $inputArraycount = count((array) $claimdetails);

            // return $inputArray;
            if( $inputArraycount <= 0){
            $input = [
                'school_name' => $inputArray['school_name'],
                'school_principal_name' => $inputArray['school_principal_name'],
                'school_building_name' => $inputArray['school_building_name'],
                'school_builiding_address' => $inputArray['school_builiding_address'],
                'school_district' => $inputArray['school_district'],
                'building_contract' => $inputArray['building_contract'],
                'admin_contract' => $inputArray['admin_contract'],
                'phone_number' => $inputArray['phone_number'],
                'status' => $inputArray['status'],
                'telephone_number' => $inputArray['telephone_number'],
                'school_email' => $inputArray['school_email'],
                'year_of_establishment' => $inputArray['year_of_establishment'],
                'totalstudent_population' => $inputArray['totalstudent_population'],
                'totalteacher_population' => $inputArray['totalteacher_population'],
                'infra_facility' => $inputArray['infra_facility'],
                'school_curriculam' => $inputArray['school_curriculam'],
                'school_policy' => $inputArray['school_policy'],
                'school_type' => $inputArray['school_type'],
                'school_teacher_ratio' => $inputArray['school_teacher_ratio'],
                'have_exclusion_policy' => $inputArray['have_exclusion_policy'],
                'multidisciplinary_team' => $inputArray['multidisciplinary_team'],
                'multidisciplinary_team_desc' => $inputArray['multidisciplinary_team_desc'],
            ];
            //    $this->WriteFileLog($inputArray);    


            $school_type = json_encode($input['school_type'], JSON_FORCE_OBJECT);
            $school_teacher_ratio = json_encode($input['school_teacher_ratio'], JSON_FORCE_OBJECT);
            $school_policy = json_encode($input['school_policy'], JSON_FORCE_OBJECT);
            $infra_facility = json_encode($input['infra_facility'], JSON_FORCE_OBJECT);
            $school_curriculam = json_encode($input['school_curriculam'], JSON_FORCE_OBJECT);




            DB::transaction(function () use ($input) {


                $school_type = json_encode($input['school_type'], JSON_FORCE_OBJECT);
                $school_teacher_ratio = json_encode($input['school_teacher_ratio'], JSON_FORCE_OBJECT);
                $school_policy = json_encode($input['school_policy'], JSON_FORCE_OBJECT);
                $infra_facility = json_encode($input['infra_facility'], JSON_FORCE_OBJECT);
                $school_curriculam = json_encode($input['school_curriculam'], JSON_FORCE_OBJECT);
                $claimdetails = DB::table('school_enrollment_details')->orderBy('school_enrollment_id', 'desc')->first();

                if ($claimdetails == null) {

                    $enrollmentnum    =  'SCL/EN/' . date("Y") . '/' . date("M") . '/001';
                } else {

                    $enrollmentchildnum = $claimdetails->school_enrollment_num;
                    $enrollmentnum = ++$enrollmentchildnum;
                }
                $inputArraycount = count($input);

                $school_enroll = DB::table('school_enrollment_details')->insertGetId([

                    'school_enrollment_num' =>  $enrollmentnum,
                    'school_name' => $input['school_name'],
                    'school_principal_name' => $input['school_principal_name'],
                    'school_building_name' => $input['school_building_name'],
                    'school_builiding_address' => $input['school_builiding_address'],
                    'school_district' => $input['school_district'],
                    'building_contract' => $input['building_contract'],
                    'admin_contract' => $input['admin_contract'],
                    'phone_number' => $input['phone_number'],
                    'telephone_number' => $input['telephone_number'],
                    'school_email' => $input['school_email'],
                    'year_of_establishment' => $input['year_of_establishment'],
                    'totalstudent_population' => $input['totalstudent_population'],
                    'totalteacher_population' => $input['totalteacher_population'],
                    'have_exclusion_policy' => $input['have_exclusion_policy'],
                    'multidisciplinary_team' => $input['multidisciplinary_team'],
                    'multidisciplinary_team_desc' => $input['multidisciplinary_team_desc'],

                    'school_type' => $school_type,
                    'school_teacher_ratio' => $school_teacher_ratio,
                    'school_policy' => $school_policy,
                    'infra_facility' => $infra_facility,
                    'school_curriculam' => $school_curriculam,

                    'status' => 'Submitted',





                    // // 'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);

                // $this->WriteFileLog($school_enroll);  


                $this->auditLog('school_enrollment_details', $school_enroll, 'Create', 'create new enrollment', '0', NOW(), 'enrolled');

                // $this->notificationstable( $input['child_name'], 'Enrolled', ' Create a Enrollment', ' User Enrolled successfully');

                // $notifications = DB::table('notifications')->insertGetId([
                //     // 'user_id' => 0,

                //     'notification_type' => 'create a user',
                //     'notification_status' => 'User enrolled',  
                //     'notification_url' => 'enrollement/'.encrypt($school_enroll),    
                //     'megcontent' => "Dear ".$input['school_name']." Successfully Enrolled with Elina Services and mail sent.",
                //     'alert_meg' => "Dear ".$input['school_name']." Successfully Enrolled With Elina and mail sent.",
                //     // // 'created_by' => auth()->user()->id,
                //     'created_at' => NOW()
                // ]);
                $admin_details = DB::SELECT("SELECT *from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,

                            'notification_type' => 'create a user',
                            'notification_status' => 'User enrolled',
                            'notification_url' => 'enrollement/schoolshow/' . encrypt($school_enroll),
                            'megcontent' => $input['school_name'] . " Enrolled Successfully and Mail Sent.",
                            'alert_meg' => $input['school_name'] . " Enrolled Successfully and Mail Sent.",
                            // // 'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            });

            $email = $inputArray['school_email'];


            $data = array(
                'school_name' => $inputArray['school_name'],
                'school_email' => $inputArray['school_email'],

            );
            Mail::to($data['school_email'])->send(new schoolenrollmail($data));
            // dispatch(new schoolmailjob($data))->delay(now()->addSeconds(1));







            $users = DB::select("SELECT * from users where array_roles = '4' or array_roles = '5'");
            // $this->WriteFileLog($users);
            $email = $users[0]->email;

            // $this->WriteFileLog('emailstart');

            $admin_email = count($users);
            // if ($email != [] ) {
            //     for ($j=0; $j < $admin_email; $j++) { 

            //         $name = $users[$j]->name;
            //         $email = $users[$j]->email;
            //         $data = array(
            //             'admin' => $name,
            //             'name' => $input['school_principal_name'],
            //             'email'  => $email,
            //             'school_name' => $input['school_name'],
            //             'phone_number' => $input['phone_number'],

            //         );
            //         // $this->WriteFileLog($data);
            //         // dispatch(new schooladminmailjob($data))->delay(now()->addSeconds(1));
            //         Mail::to($data['email'])->send(new schooladminenrollmail($data));
            //     }
            // }

            $data = array(
                // 'admin' => $name,
                'name' => $input['school_principal_name'],
                // 'email'  => $email,
                'school_name' => $input['school_name'],
                'phone_number' => $input['phone_number'],

            );
            // $this->WriteFileLog($data);
            // dispatch(new schooladminmailjob($data))->delay(now()->addSeconds(1));
            Mail::to(config('setting.enrollment.school'))->bcc(config('setting.enrollment.bcc'))->send(new schooladminenrollmail($data));


            if ($react_web) {
                return response()->json([
                    'message' => 'School enrollment completed succesfully',
                    'code' => 200
                ], 200);
            }


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        }else{
            if ($react_web) {
                return response()->json([
                    'message' => 'The provided school email address has already been registered.',
                    'code' => 400
                ], 400);
            }
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.validation');
            $serviceResponse['Message'] = 'School email is already exists';
            $serviceResponse['Data'] = 0;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), true);
            return $sendServiceResponse;
        }
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

            $method = 'Method => SchoolenrollmentController => data_edit';
            $this->WriteFileLog($method);





            $id = $this->DecryptData($id);


            $rows = DB::table('school_enrollment_details as a')


                ->select('a.*')
                ->where('a.school_enrollment_id', $id)
                ->get();
            $this->WriteFileLog($id);




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

    public function updatedata(Request $request)
    {

        try {
            // $this->WriteFileLog($request);
            $method = 'Method =>  SchoolenrollmentController => updatedata';
            // $this->WriteFileLog($method);
            $inputArray = $this->decryptData($request->requestData);
            $input = [

                'id' => $inputArray['id'],

                'school_name' => $inputArray['school_name'],
                'school_principal_name' => $inputArray['school_principal_name'],
                'school_building_name' => $inputArray['school_building_name'],
                'school_builiding_address' => $inputArray['school_builiding_address'],
                'school_district' => $inputArray['school_district'],
                'building_contract' => $inputArray['building_contract'],
                'admin_contract' => $inputArray['admin_contract'],
                'phone_number' => $inputArray['phone_number'],
                'status' => $inputArray['status'],
                'telephone_number' => $inputArray['telephone_number'],
                'school_email' => $inputArray['school_email'],
                'year_of_establishment' => $inputArray['year_of_establishment'],
                'totalstudent_population' => $inputArray['totalstudent_population'],
                'totalteacher_population' => $inputArray['totalteacher_population'],
                'infra_facility' => $inputArray['infra_facility'],
                'school_curriculam' => $inputArray['school_curriculam'],
                'school_policy' => $inputArray['school_policy'],
                'school_type' => $inputArray['school_type'],
                'school_teacher_ratio' => $inputArray['school_teacher_ratio'],
                'have_exclusion_policy' => $inputArray['have_exclusion_policy'],
                'multidisciplinary_team' => $inputArray['multidisciplinary_team'],
                'multidisciplinary_team_desc' => $inputArray['multidisciplinary_team_desc'],
            ];






            // $this->WriteFileLog($inputArray);



            DB::transaction(function () use ($input) {







                DB::table('school_enrollment_details')
                    ->where('school_enrollment_id', $input['id'])
                    ->update([


                        'school_name' => $input['school_name'],
                        'school_principal_name' => $input['school_principal_name'],
                        'school_building_name' => $input['school_building_name'],
                        'school_builiding_address' => $input['school_builiding_address'],
                        'school_district' => $input['school_district'],
                        'building_contract' => $input['building_contract'],
                        'admin_contract' => $input['admin_contract'],
                        'phone_number' => $input['phone_number'],
                        'telephone_number' => $input['telephone_number'],
                        'school_email' => $input['school_email'],
                        'year_of_establishment' => $input['year_of_establishment'],
                        'totalstudent_population' => $input['totalstudent_population'],
                        'have_exclusion_policy' => $input['have_exclusion_policy'],
                        'multidisciplinary_team' => $input['multidisciplinary_team'],
                        'multidisciplinary_team_desc' => $input['multidisciplinary_team_desc'],

                        'school_type' => $input['school_type'],
                        'school_teacher_ratio' => $input['school_teacher_ratio'],
                        'school_policy' => $input['school_policy'],
                        'infra_facility' => $input['infra_facility'],
                        'school_curriculam' => $input['school_curriculam'],

                        'status' => 'saved',

                    ]);
                //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                //   $role_name_fetch=$role_name[0]->role_name;
            });

            // $this->WriteFileLog($input);

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
}
