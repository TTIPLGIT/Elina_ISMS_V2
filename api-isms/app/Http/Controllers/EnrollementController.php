<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\serviceinternusermail;
use App\Mail\serviceinternmail;
use App\Mail\SendMail;
use App\Mail\NewServiceProviderUserMail;
use App\Mail\registermail;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\sendadminenrollmail;
use App\Mail\NewServiceProviderMail;
use DateTime;

class EnrollementController extends BaseController
{
    public function createdata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => EnrollementController => createdata';

            // $this->WriteFileLog($method);
            $rows = DB::select('select * from enrollment_details');


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
        try {
            $method = 'Method => EnrollementController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $date = DateTime::createFromFormat('Y-m-d', $inputArray['child_dob']);
            $formattedDoB = $date->format('d/m/Y');
            $input = [
                'child_name' => $inputArray['child_name'],
                'child_dob' => $formattedDoB,
                'child_school_name_address' => $inputArray['child_school_name_address'],
                'child_gender' => $inputArray['child_gender'],
                'child_father_guardian_name' => $inputArray['child_father_guardian_name'],
                'child_mother_caretaker_name' => $inputArray['child_mother_caretaker_name'],
                'child_contact_email' => $inputArray['child_contact_email'],
                'child_contact_phone' => $inputArray['child_contact_phone'],
                'child_contact_address' => $inputArray['child_contact_address'],
                'status' => $inputArray['status'],
                'services_from_elina' => $inputArray['services_from_elina'],
                'how_knowabt_elina' => $inputArray['how_knowabt_elina'],
                // 'consent_form' => $inputArray['consent_form'],
                'name' => $inputArray['name'],
                'child_alter_phone' => $inputArray['child_alter_phone'],
                'email' => $inputArray['email'],
                'password' => $inputArray['password'],
                'Mobile_no' => $inputArray['Mobile_no'],
                'dor' => $inputArray['dor'],
            ];

            $mapping = array(
                'ELiNA Website' => "Through Elina's Website",
                'Social Media' => "Through Facebook and Social Media",
                'Through HLC' => "Through HLC Admission",
                'Through other schools' => "Through Other School",
                'Through other parents' => "Through Other Parent",
                'Through friends' => "From a Friend",
                'Through my therapists' => "Recommended by Child's therapist",
                'others' => 'others'
            );

            foreach ($input['how_knowabt_elina'] as $key => $value) {
                if (array_key_exists($value, $mapping)) {
                    $input['how_knowabt_elina'][$key] = $mapping[$value];
                }
            }

            $child_contact_email = $inputArray['child_contact_email'];
            $services_from_elina = json_encode($input['services_from_elina'], JSON_FORCE_OBJECT);
            $how_knowabt_elina = json_encode($input['how_knowabt_elina'], JSON_FORCE_OBJECT);

            $email = $input['email'];
            $email_check = DB::select("select * from users where email = '$email'");
            $user_check = DB::select("select * from enrollment_details where child_contact_email = '$child_contact_email' and active_flag = 0");
            if (json_encode($user_check) == '[]' && json_encode($email_check) == '[]') {
                $responseData =  DB::transaction(function () use ($input, $email, $inputArray) {

                    $user_id = DB::table('users')
                        ->insertGetId([
                            'name' => $input['child_name'],
                            'email' => $input['email'],
                            'password' => $input['password'],
                            'Mobile_no' => $input['Mobile_no'],
                            'dor' => today(),
                            'project_role_id' => 1,
                            'array_dashboard_list' => 1,
                            'designation_id' => 2,
                            // 'role' => '1',
                            'active_flag' => 0,
                            'created_at' => NOW(),
                            'array_roles' => 3,
                            'profile_image' => '/images/profile-picture.webp',
                        ]);

                    $services_from_elina = json_encode($input['services_from_elina'], JSON_FORCE_OBJECT);
                    $how_knowabt_elina = json_encode($input['how_knowabt_elina'], JSON_FORCE_OBJECT);

                    $claimdetails = DB::table('enrollment_details')->orderBy('enrollment_id', 'desc')->first();
                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'CH/' . date("Y") . '/001';
                        $enrollmentnum    =  'EN/' . date("Y") . '/' . date("M") . '/001';
                    }
                    // else {
                    //     $claimnoticeno = $claimdetails->child_id;
                    //     $claimnoticenoNew =  ++$claimnoticeno;
                    //     $enrollmentchildnum = $claimdetails->enrollment_child_num;
                    //     $enrollmentnum = ++$enrollmentchildnum;
                    // }
                    else {
                        $lastThreeDigits = intval(substr($claimdetails->child_id, -3));
                        $newThreeDigits = str_pad($lastThreeDigits + 1, 3, '0', STR_PAD_LEFT);
                        $claimnoticenoNew = 'CH/' . date("Y") . '/' . $newThreeDigits;

                        $lastThreeDigitsEnrollment = intval(substr($claimdetails->enrollment_child_num, -3));
                        $newThreeDigitsEnrollment = str_pad($lastThreeDigitsEnrollment + 1, 3, '0', STR_PAD_LEFT);
                        $enrollmentnum = 'EN/' . date("Y") . '/' . date("m") . '/' . $newThreeDigitsEnrollment;
                    }
                    // $this->WriteFileLog($enrollmentnum);exit;
                    if ($inputArray['child_school'] == 'others') {
                        $school_id = 0;
                        $paymentCategory = 1;
                    } else {
                        $school_id = $inputArray['child_school'];
                        $paymentCategory = 2;
                    }
                    // $this->WriteFileLog($input['child_school_name_address']);
                    
                    if ($input['child_school_name_address'] == null) {
                        
                        $schoolAddress = DB::table('schools_registration')
                            ->where('id', $inputArray['child_school'])
                            ->value('school_address');
                    
                            // $this->WriteFileLog($schoolAddress);
                    
                            $input['child_school_name_address'] = $schoolAddress ?? null;

                    }
                    
                    // $this->WriteFileLog($input['child_contact_address']);
                    $screen_permission_id1 = DB::table('enrollment_details')->insertGetId([
                        'enrollment_child_num' =>  $enrollmentnum,
                        'child_name' => $input['child_name'],
                        'child_dob' => $input['child_dob'],
                        'child_school_name_address' => $input['child_school_name_address'],
                        'child_gender' => $input['child_gender'],
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_mother_caretaker_name' => $input['child_mother_caretaker_name'],
                        'child_contact_email' => $input['child_contact_email'],
                        'child_contact_phone' => $input['child_contact_phone'],
                        'child_contact_address' => $input['child_contact_address'],
                        'services_from_elina' => $services_from_elina,
                        'how_knowabt_elina' => $how_knowabt_elina,
                        'child_alter_phone' => $input['child_alter_phone'],
                        'active_flag' => 0,
                        'flag' => 1,
                        'child_id' => $claimnoticenoNew,
                        'user_id' => $user_id,
                        'status' => 'Submitted',
                        'consent_aggrement' => 'Agreed',
                        'category_id' => $paymentCategory,
                        'school_id' => $school_id,
                        'created_date' => NOW()
                    ]);
                    $this->updateGoogleEvent();
                    $payment = DB::select("select * from payment_structure where fees_type='enroll'and status='Active' ");
                    $activePayment = $this->getFeeDetails('1', $paymentCategory, $inputArray['child_school']);
                    $payableAmount = $activePayment->final_amount;
                    $paymentID = $activePayment->id;
                    $baseAmount = $activePayment->base_amount;
                    $gstAmount = ($baseAmount / 100) * $activePayment->gst_rate;

                    $serviceList = DB::select("SELECT * FROM payment_process_services WHERE payment_process_master_id = $paymentID");
                    $response = [
                        'enrollment_child_num' => $enrollmentnum,
                        'child_id' => $claimnoticenoNew,
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_name' => $input['child_name'],
                        'initiated_by' => config('setting.email_id'),
                        'initiated_to' => $input['child_contact_email'],
                        'payment_amount' => $payableAmount,
                        'user_id' => $user_id,
                        'payment_status' => 'New',
                        'payment_process_description' => 'Kindly Pay Rs.' . $payableAmount . ' for your Registration',
                        'paymenttokentime' => '2800',
                        'enrollment_id' => $screen_permission_id1,
                        'baseAmount' => $baseAmount,
                        'gstAmount' => $gstAmount,
                        'masterData' => $response = [
                            'serviceList' => $serviceList
                        ],
                    ];
                    //Parent UAM
                    // $stringuser_id = 3;
                    // DB::table('users')
                    // 	->where('id', $user_id)
                    // 	->update([
                    // 		'array_roles' => $stringuser_id,
                    // 	]);
                    // $user_id  =  $user_id;
                    DB::table('uam_user_roles')->insertGetId([
                        'user_id' => $user_id,
                        'role_id' => 3,
                        'active_flag' => 0,
                        'created_by' => $user_id,
                        'created_date' => NOW()
                    ]);

                    $role_id = 3;
                    $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
                    $parentidcounting = count($parentrow);
                    if ($parentrow != []) {
                        for ($j = 0; $j < $parentidcounting; $j++) {
                            $module_id = $parentrow[$j]->module_id;
                            $screen_id = $parentrow[$j]->screen_id;
                            $x = 0;
                            $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
                            if ($modulesrows != []) {
                                $parent_module_id = $modulesrows[$x]->parent_module_id;
                                $module_name = $modulesrows[$x]->module_name;
                            }

                            $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
                            if ($screenrows != []) {
                                $screen_name = $screenrows[$x]->screen_name;
                                $screen_url = $screenrows[$x]->screen_url;
                                $route_url = $screenrows[$x]->route_url;
                                $class_name = $screenrows[$x]->class_name;
                                $display_order = $screenrows[$x]->display_order;
                            }

                            $check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
                            $checkcount = count($check);
                            if ($checkcount == 0) {
                                $screen_permission_id = DB::table('uam_user_screens')->insertGetId([
                                    'screen_id' => $screen_id,
                                    'module_id' => $module_id,
                                    'parent_module_id' => $parent_module_id,
                                    'module_name' => $module_name,
                                    'screen_name' => $screen_name,
                                    'screen_url' => $screen_url,
                                    'route_url' => $route_url,
                                    'class_name' => $class_name,
                                    'display_order' => $display_order,
                                    'user_id' => $user_id,
                                    'active_flag' => 0,
                                    'created_by' => $user_id,
                                    'created_date' => NOW()
                                ]);
                            }
                        };
                    };

                    $checking = DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");
                    $checkcounting = count($checking);
                    if ($checking != []) {
                        for ($k = 0; $k < $checkcounting; $k++) {
                            $screen_id = $checking[$k]->screen_id;
                            $user_screen_id = $checking[$k]->user_screen_id;

                            $permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
								inner join uam_role_screen_permissions as b on b.screen_permission_id = a.screen_permission_id
								where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

                            $permissioncheckcount = count($permissioncheck);
                            for ($m = 0; $m < $permissioncheckcount; $m++) {
                                $screen_permission_id = $permissioncheck[$m]->screen_permission_id;
                                $permission_name = $permissioncheck[$m]->permission;
                                $description = $permissioncheck[$m]->description;
                                $active_flag = $permissioncheck[$m]->active_flag;
                                $array_permission = $permissioncheck[$m]->array_permission;
                                $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
                                    'user_screen_id' =>  $user_screen_id,
                                    'screen_permission_id' =>  $screen_permission_id,
                                    'permission' => $permission_name,
                                    'description' => $description,
                                    'active_flag' => $active_flag,
                                    'array_permission' => $array_permission,
                                    'user_id' => $user_id,
                                    'created_by' => $user_id,
                                    'created_date' => NOW()
                                ]);
                            };
                        };
                    };
                    //End UAM
                    $this->auditLog('enrollment_details', $screen_permission_id, 'Create', 'New Enrollment', '', NOW(), 'Parent');
                    $this->StudentsLogs('enrollment_details', $screen_permission_id, 'Enrollment ' . $input['status'], $user_id, NOW());
                    //    // Email & System Notification
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'create a user',
                                'notification_status' => 'User enrolled',
                                'notification_url' => 'newenrollment/' . encrypt($screen_permission_id1),
                                'megcontent' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully",
                                'alert_meg' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully",
                                // 'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);

                            // $name = $admin_details[$j]->name;
                            // $email = $admin_details[$j]->email;
                            // $data = array(
                            //     'name' => $name,
                            //     'email' => $email,
                            //     'child_name' => $inputArray['child_name'],
                            //     // 'consent_form' => $inputArray['consent_form'],
                            // );
                            // Mail::to($data['email'])->send(new sendadminenrollmail($data));
                            // // dispatch(new adminenrolljob($data))->delay(now()->addSeconds(1));//Register Mail - Admin
                        }
                    }

                    $data = array(
                        // 'name' => $name,
                        // 'email' => $email,
                        'child_name' => $inputArray['child_name'],
                        // 'consent_form' => $inputArray['consent_form'],
                    );
                    // $this->WriteFileLog('asd');
                    Mail::to(config('setting.enrollment.parent'))->bcc(config('setting.enrollment.bcc'))->send(new sendadminenrollmail($data));

                    $email = $inputArray['child_contact_email'];
                    // $this->WriteFileLog('asd1');

                    $data = array(
                        'name' => $inputArray['name'],
                        'email' => $inputArray['email'],
                        'password' => $inputArray['password_confirmation'],
                    );
                    Mail::to($email)->send(new registermail($data));
                    // $this->WriteFileLog('asd3');

                    // $data = array(
                    //     'child_name' => $inputArray['child_name'],
                    //     'child_contact_email' => $inputArray['child_contact_email'],
                    //     // 'consent_form' => $inputArray['consent_form'],
                    //     'name' => $inputArray['name'],
                    //     'email' => $inputArray['email'],
                    //     'password' => $inputArray['password_confirmation'],
                    // );
                    // Mail::to($data['child_contact_email'])->send(new SendMail($data)); //Register Mail - User

                    return $response;
                });
                // Login To Portal

                $userId = $responseData['user_id'];
                $user = User::find($userId);

                $myTTL = 120; //minutes
                auth()->factory()->setTTL($myTTL);

                if (!$token = auth()->fromUser($user)) {
                    DB::table('mismatch_attempt_audit')
                        ->insertGetId([
                            'status' => 'Mismatch_Credential',
                            'email' => $request->email,
                            'password' => $request->password,
                        ]);
                    $serviceResponse = array();
                    $serviceResponse['Code'] = config('setting.status_code.unauthenticated');
                    $serviceResponse['Message'] = config('setting.status_message.unauthenticated');
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
                    return $sendServiceResponse;
                }


                if (auth()->fromUser($user)) {

                    Auth::login($user);
                    $user = auth()->user();
                    $serviceResponse1 = array();
                    $serviceResponse1['access_token'] = $token;
                    $serviceResponse1['token_type'] = 'Bearer';
                    $serviceResponse1['expires_in'] = $myTTL;
                    $serviceResponse1['user'] = auth()->user();
                } else {
                    log::error('fail');
                    $serviceResponse = array();
                    $serviceResponse['Code'] = 500;
                    $serviceResponse['Message'] = 'Not activated';
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, 500, false);
                    return $sendServiceResponse;
                }

                $token = auth()->fromUser($user);
                $payload = JWTAuth::setToken($token)->getPayload();
                $expirationTime = $payload->get('exp');
                $dateTime = Carbon::createFromTimestamp($expirationTime, 'UTC');
                $dateTime->setTimezone('Asia/Kolkata');
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

                $data = array();
                $data['hostname'] = gethostname();
                $data['formattedDateTime'] = $formattedDateTime;
                $encryhostname = $this->EncryptData($data);

                DB::table('login_audit')
                    ->insertGetId([
                        'status' => 'Login',
                        'user_id' => auth()->user()->id,
                        'login_token' => $encryhostname,
                    ]);

                $serviceResponse1['formattedDateTime'] = $formattedDateTime;
                // 
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $responseData;
                $serviceResponse['serviceResponse1'] = $serviceResponse1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
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
    public function serviveprovider(Request $request)
    {

        //return $request;
        try {
            $method = 'Method => serviceprovider => storedata';
            // $this->WriteFileLog($method);

            $inputArray = $request;

            // return $inputArray;
            $email = $inputArray['email_address'];
            $claimdetails = DB::table('service_provider')
                ->where('email_address', '=', $inputArray['email_address'])
                ->get()
                ->toArray();
            $react_web = isset($request->react_web) ? $request->react_web : FALSE;
            $inputArraycount = count((array) $claimdetails);
            $input = [
                'name' => $inputArray['name'],
                'gender' => $inputArray['gender'],
                'phone_number' => $inputArray['phone_number'],
                'email_address' => $inputArray['email_address'],
                'area_of_specializtion' => $inputArray['area_of_specializtion'],
                'type_of_service' => $inputArray['type_of_service'],
                'mode_of_service' => $inputArray['mode_of_service'],
                'providing_home_service' => $inputArray['providing_home_service'],
                'profession_charges_per_session' => $inputArray['profession_charges_per_session'],
                'universtiy_name' => $inputArray['universtiy_name'],
                'profession_qualification' => $inputArray['profession_qualification'],
                'year_of_completion' => $inputArray['year_of_completion'],
                'work_experience' => $inputArray['work_experience'],
                'specialist_in' => $inputArray['specialist_in'],
                'organisation_name' => $inputArray['organisation_name'],
                'organisation_head_name' => $inputArray['organisation_head_name'],
                'organisation_email_address' => $inputArray['organisation_email_address'],
                'organisation_website_info' => $inputArray['organisation_website_info'],
                'specification_limitation_constraint' => $inputArray['specification_limitation_constraint'],
                'agree_of_acknowledgement' => $inputArray['agree_of_acknowledgement'],
            ];

            if ($inputArraycount <= 0) {
                $mode_of_service = json_encode($input['mode_of_service'], JSON_FORCE_OBJECT);
                // $internship_application_form = json_encode($input['rnship_application_form'], JSON_FORCE_OBJECT);




                DB::transaction(function () use ($input) {


                    $area_of_specializtion = json_encode($input['area_of_specializtion'], JSON_FORCE_OBJECT);
                    $mode_of_service = json_encode($input['mode_of_service'], JSON_FORCE_OBJECT);
                    $claimdetails = DB::table('service_provider')
                        ->where('email_address', '=', $input['email_address'])
                        ->get()
                        ->toArray();

                    $inputArraycount = count((array) $claimdetails);

                    if ($inputArraycount > 0) {
                    }
                    $screen_permission_id = DB::table('service_provider')->insertGetId([
                        'name' =>  $input['name'],
                        'gender' => $input['gender'],
                        'phone_number' => $input['phone_number'],
                        'email_address' => $input['email_address'],
                        'area_of_specializtion' => $area_of_specializtion,
                        'type_of_service' => $input['type_of_service'],
                        'providing_home_service' => $input['providing_home_service'],
                        'mode_of_service' => $mode_of_service,
                        'profession_charges_per_session' => $input['profession_charges_per_session'],
                        'universtiy_name' => $input['universtiy_name'],
                        'profession_qualification' => $input['profession_qualification'],
                        'year_of_completion' => $input['year_of_completion'],
                        'work_experience' => $input['work_experience'],
                        'specialist_in' => $input['specialist_in'],
                        'universtiy_name' => $input['universtiy_name'],
                        'profession_qualification' => $input['profession_qualification'],
                        'organisation_name' => $input['organisation_name'],
                        'organisation_head_name' => $input['organisation_head_name'],
                        'organisation_email_address' => $input['organisation_email_address'],
                        'organisation_website_info' => $input['organisation_website_info'],
                        'specification_limitation_constraint' => $input['specification_limitation_constraint'],
                        'agree_of_acknowledgement' => $input['agree_of_acknowledgement'],
                        'status' => 'submitted',
                        'created_by' =>  $input['name'],
                        'created_at' => NOW()
                    ]);




                    $this->auditLog('service provider', $screen_permission_id, 'Create', 'create new service provider', 0, NOW(), ' $role_name_fetch');

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            $notifications = DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'create a user',
                                'notification_status' => 'User enrolled',
                                'notification_url' => 'serviceprovider/' . encrypt($screen_permission_id),
                                'megcontent' => "Service Provider " . $input['name'] . " has been Enrolled Successfully and Mail Sent.",
                                'alert_meg' => "Service Provider " . $input['name'] . " has been Enrolled Successfully and Mail Sent.",
                                'created_by' => 0,
                                'created_at' => NOW()
                            ]);
                            // $data = [
                            //     'email' => $admin_details[$j]->email,
                            //     'name' => $admin_details[$j]->name,
                            //     'serviceprovidername' => $input['name'],
                            // ];
                            // // dispatch(new serviceinternmailjob($data))->delay(now()->addSeconds(1));
                            // Mail::to($admin_details[$j]->email)->send(new NewServiceProviderMail($data));

                        }
                    }
                    $data = [
                        // 'email' => $admin_details[$j]->email,
                        // 'name' => $admin_details[$j]->name,
                        'serviceprovidername' => $input['name'],
                    ];
                    // dispatch(new serviceinternmailjob($data))->delay(now()->addSeconds(1));
                    Mail::to(config('setting.enrollment.service_provider'))->bcc(config('setting.enrollment.bcc'))->send(new NewServiceProviderMail($data));
                });
                $data = array(
                    'name' => $inputArray['name'],
                    'email' => $inputArray['email_address'],

                );
                // dispatch(new serviceinternusermailjob($data))->delay(now()->addSeconds(1));
                Mail::to($data['email'])->send(new NewServiceProviderUserMail($data));
                if ($react_web) {
                    return response()->json([
                        'message' => 'Service provider Added Successfully',
                        'code' => 200
                    ], 200);
                }
            } else {
                if ($react_web) {
                    return response()->json([
                        'message' => 'The provided email address has already been registered.',
                        'code' => 400
                    ], 400);
                }
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
    public function internship(Request $request)
    {

        //return $request;
        try {
            $method = 'Method => Intern => storedata';
            // $this->WriteFileLog($method);

            // $this->WriteFileLog($request);
            $inputArray = $this->decryptData($request->requestData);
            // $this->WriteFileLog($inputArray);
            // return $inputArray;
            $email = $inputArray['email_address'];
            $claimdetails = DB::table('internship_application_form')
                ->where('email_address', '=', $inputArray['email_address'])
                ->get()
                ->toArray();
            $react_web = isset($request->react_web) ? $request->react_web : FALSE;
            $inputArraycount = count((array) $claimdetails);
            if ($inputArraycount <= 0) {
                $input = [
                    'name' => $inputArray['name'],
                    'date_of_birth' => $inputArray['date_of_birth'],
                    'contact_number' => $inputArray['contact_number'],
                    'parent_guardian_contact_number' => $inputArray['parent_guardian_contact_number'],
                    'start_date_with_elina' => $inputArray['start_date_with_elina'],
                    'hours_intern_elina_per_week' => $inputArray['hours_intern_elina_per_week'],
                    'email_address' => $inputArray['email_address'],
                    'agreement' => $inputArray['agreement'],
                    'short_introduction_fn' => $inputArray['short_introduction_fn'],
                    'short_introduction_fp' => $inputArray['short_introduction_fp'],
                    'about_elina_fn' => $inputArray['about_elina_fn'],
                    'about_elina_fp' => $inputArray['about_elina_fp'],
                    'intern_with_elina_fn' => $inputArray['intern_with_elina_fn'],
                    'intern_with_elina_fp' => $inputArray['intern_with_elina_fp'],
                ];

                // $this->WriteFileLog($inputArray);
                DB::transaction(function () use ($input) {
                    $screen_permission_id = DB::table('internship_application_form')->insertGetId([
                        'name' =>  $input['name'],
                        'date_of_birth' => $input['date_of_birth'],
                        'contact_number' => $input['contact_number'],
                        'parent_guardian_contact_number' => $input['parent_guardian_contact_number'],
                        'start_date_with_elina' => $input['start_date_with_elina'],
                        'hours_intern_elina_per_week' => $input['hours_intern_elina_per_week'],
                        'email_address' => $input['email_address'],
                        'agreement' => $input['agreement'],
                        'short_introduction_fn' => $input['short_introduction_fn'],
                        'short_introduction_fp' => $input['short_introduction_fp'],
                        'about_elina_fn' => $input['about_elina_fn'],
                        'about_elina_fp' => $input['about_elina_fp'],
                        'intern_with_elina_fn' => $input['intern_with_elina_fn'],
                        'intern_with_elina_fp' => $input['intern_with_elina_fp'],
                        'status' => 'submitted',
                        'created_by' => $input['name'],
                        'created_at' => NOW()
                    ]);

                    $this->auditLog('internship', $screen_permission_id, 'Create', 'create new internship', 0, NOW(), ' $role_name_fetch');

                    // $admin_details = DB::SELECT("SELECT *from users where array_roles = '4' or array_roles = '5' ");
                    // $adminn_count = count($admin_details);
                    // if ($admin_details != []) {
                    //     for ($j = 0; $j < $adminn_count; $j++) {

                    //         $notifications = DB::table('notifications')->insertGetId([
                    //             'user_id' =>  $admin_details[$j]->id,

                    //             'notification_type' => 'create a user',
                    //             'notification_status' => 'User enrolled',
                    //             'notification_url' => 'internship/' . encrypt($screen_permission_id),
                    //             'megcontent' => "Intern " . $input['name'] . " has been Enrolled Successfully and Mail Sent.",
                    //             'alert_meg' => "Intern " . $input['name'] . " has been Enrolled Successfully and Mail Sent.",
                    //             'created_by' => 0,
                    //             'created_at' => NOW()
                    //         ]);

                    //         $data = [
                    //             'email' => $admin_details[$j]->email,
                    //             'name' => $admin_details[$j]->name,
                    //             'serviceprovidername' => $input['name'],
                    //         ];
                    //         Mail::to($admin_details[$j]->email)->send(new serviceinternmail($data));
                    //         // dispatch(new serviceinternmailjob($data))->delay(now()->addSeconds(1));
                    //     }
                    // }
                    $data = [
                        // 'email' => $admin_details[$j]->email,
                        // 'name' => $admin_details[$j]->name,
                        'serviceprovidername' => $input['name'],
                    ];
                    Mail::to(config('setting.enrollment.intern'))->bcc(config('setting.enrollment.bcc'))->send(new serviceinternmail($data));
                });




                $data = array(
                    'name' => $inputArray['name'],
                    'email' => $inputArray['email_address'],

                );

                Mail::to($data['email'])->send(new serviceinternusermail($data));
                // for ($i = 1; $i <= 5; $i++) {
                //     dispatch(new serviceinternusermailjob($data))->delay(now()->addMinutes($i));
                // }

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.validation');
                $serviceResponse['Message'] = "Email Address already exists";
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

    public function ValidateEnrollment(Request $request)
    {
        try {
            $logMethod = 'Method => EnrollementController => ValidateEnrollment';
            $InputName = $request->InputName;
            $InputDoB = $request->InputDoB;

            $InputName1 = preg_replace('/\s+/', '', $InputName);

            $enrollmentID = DB::select("SELECT * FROM enrollment_details WHERE (child_name = '$InputName' OR child_name = '$InputName1') AND child_dob = '$InputDoB'");
            // $this->WriteFileLog(json_encode($enrollmentID));
            if (json_encode($enrollmentID) == '[]') {
                $responceData = 0;
            } else {
                $responceData = 1;
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $responceData;
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
    public function updateGoogleEvent()
    {
        // $this->WriteFileLog("ASdae");
        // Get the current date for comparison
        $currentDate = Carbon::now()->format('Y-m-d');

        // Retrieve all records with status 'Ready'
        $details = DB::table('payment_structure')
            ->where('status', 'Ready')
            ->get();

        foreach ($details as $row) {
            $id = $row->id;
            $feesType = $row->fees_type;
            $effectiveDate = Carbon::parse($row->effective_date)->format('Y-m-d');

            // Prepare the effective date
            $formattedSelectedDate = Carbon::now()->format('Y-m-d'); // Assuming selectedDate should be current date

            if ($formattedSelectedDate === $currentDate) {
                // Update the current record to 'Active'
                DB::table('payment_structure')
                    ->where('id', $id)
                    ->update([
                        'status' => 'Active',
                        'effective_date' => $formattedSelectedDate,
                    ]);

                // Update previous records with the same fees_type to 'Expired'
                DB::table('payment_structure')
                    ->where('fees_type', $feesType)
                    ->where('id', '<>', $id) // Exclude the current record
                    ->where('status', 'Active') // Only affect currently 'Active' records
                    ->update([
                        'status' => 'Expired',
                        'expired_date' => $formattedSelectedDate,
                    ]);
            } else {
                // Update the status to 'Ready'
                DB::table('payment_structure')
                    ->where('id', $id)
                    ->update([
                        'status' => 'Ready',
                        'effective_date' => $formattedSelectedDate,
                    ]);

                // Update records with status 'Active' for the same fees_type
                DB::table('payment_structure')
                    ->where('fees_type', $feesType)
                    ->where('status', 'Active')
                    ->update([
                        'expired_date' => $formattedSelectedDate,
                    ]);
            }
        }
    }

    public function storedata_v1(Request $request)
    {
        try {
            $method = 'Method => EnrollementController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'child_name' => $inputArray['child_name'],
                'child_dob' => $inputArray['child_dob'],
                'child_school_name_address' => $inputArray['child_school_name_address'],
                'child_gender' => $inputArray['child_gender'],
                'child_father_guardian_name' => $inputArray['child_father_guardian_name'],
                'child_mother_caretaker_name' => $inputArray['child_mother_caretaker_name'],
                'child_contact_email' => $inputArray['child_contact_email'],
                'child_contact_phone' => $inputArray['child_contact_phone'],
                'child_contact_address' => $inputArray['child_contact_address'],
                'status' => $inputArray['status'],
                'services_from_elina' => $inputArray['services_from_elina'],
                'how_knowabt_elina' => $inputArray['how_knowabt_elina'],
                // 'consent_form' => $inputArray['consent_form'],
                'name' => $inputArray['name'],
                'child_alter_phone' => $inputArray['child_alter_phone'],
                'email' => $inputArray['email'],
                'password' => $inputArray['password'],
                'Mobile_no' => $inputArray['Mobile_no'],
                'dor' => $inputArray['dor'],
            ];

            $child_contact_email = $inputArray['child_contact_email'];
            $services_from_elina = json_encode($input['services_from_elina'], JSON_FORCE_OBJECT);
            $how_knowabt_elina = json_encode($input['how_knowabt_elina'], JSON_FORCE_OBJECT);

            $email = $input['email'];
            $email_check = DB::select("select * from users where email = '$email'");
            $user_check = DB::select("select * from enrollment_details where child_contact_email = '$child_contact_email' and active_flag = 0");
            if (json_encode($user_check) == '[]' && json_encode($email_check) == '[]') {
                $responseData =  DB::transaction(function () use ($input, $email, $inputArray) {

                    $user_id = DB::table('users')
                        ->insertGetId([
                            'name' => $input['child_name'],
                            'email' => $input['email'],
                            'password' => $input['password'],
                            'Mobile_no' => $input['Mobile_no'],
                            'dor' => today(),
                            'project_role_id' => 1,
                            'array_dashboard_list' => 1,
                            'designation_id' => 2,
                            // 'role' => '1',
                            'active_flag' => 0,
                            'created_at' => NOW(),
                            'array_roles' => 3,
                            'profile_image' => '/images/profile-picture.webp',
                        ]);

                    $services_from_elina = json_encode($input['services_from_elina'], JSON_FORCE_OBJECT);
                    $how_knowabt_elina = json_encode($input['how_knowabt_elina'], JSON_FORCE_OBJECT);

                    $claimdetails = DB::table('enrollment_details')->orderBy('enrollment_id', 'desc')->first();
                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'CH/' . date("Y") . '/001';
                        $enrollmentnum    =  'EN/' . date("Y") . '/' . date("M") . '/001';
                    }
                    // else {
                    //     $claimnoticeno = $claimdetails->child_id;
                    //     $claimnoticenoNew =  ++$claimnoticeno;
                    //     $enrollmentchildnum = $claimdetails->enrollment_child_num;
                    //     $enrollmentnum = ++$enrollmentchildnum;
                    // }
                    else {
                        $lastThreeDigits = intval(substr($claimdetails->child_id, -3));
                        $newThreeDigits = str_pad($lastThreeDigits + 1, 3, '0', STR_PAD_LEFT);
                        $claimnoticenoNew = 'CH/' . date("Y") . '/' . $newThreeDigits;

                        $lastThreeDigitsEnrollment = intval(substr($claimdetails->enrollment_child_num, -3));
                        $newThreeDigitsEnrollment = str_pad($lastThreeDigitsEnrollment + 1, 3, '0', STR_PAD_LEFT);
                        $enrollmentnum = 'EN/' . date("Y") . '/' . date("m") . '/' . $newThreeDigitsEnrollment;
                    }
                    // $this->WriteFileLog($enrollmentnum);exit;
                    if ($inputArray['child_school'] == 'others') {
                        $school_id = 0;
                        $paymentCategory = 1;
                    } else {
                        $school_id = $inputArray['child_school'];
                        $paymentCategory = 2;
                    }
                    
                    // $this->WriteFileLog($input['child_school_name_address']);
                    
                    if ($input['child_school_name_address'] == null) {

                        $schoolAddress = DB::table('schools_registration')
                            ->where('id', $inputArray['child_school'])
                            ->value('school_address');
                    
                            // $this->WriteFileLog($schoolAddress);
                    
                            $input['child_school_name_address'] = $schoolAddress ?? null;

                    }
                    
                    // $this->WriteFileLog($input['child_contact_address']);
                    
                    $screen_permission_id1 = DB::table('enrollment_details')->insertGetId([
                        'enrollment_child_num' =>  $enrollmentnum,
                        'child_name' => $input['child_name'],
                        'child_dob' => $input['child_dob'],
                        'child_school_name_address' => $input['child_school_name_address'],
                        'child_gender' => $input['child_gender'],
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_mother_caretaker_name' => $input['child_mother_caretaker_name'],
                        'child_contact_email' => $input['child_contact_email'],
                        'child_contact_phone' => $input['child_contact_phone'],
                        'child_contact_address' => $input['child_contact_address'],
                        'services_from_elina' => $services_from_elina,
                        'how_knowabt_elina' => $how_knowabt_elina,
                        'child_alter_phone' => $input['child_alter_phone'],
                        'active_flag' => 0,
                        'flag' => 1,
                        'child_id' => $claimnoticenoNew,
                        'user_id' => $user_id,
                        'status' => 'Submitted',
                        'consent_aggrement' => 'Agreed',
                        'category_id' => $paymentCategory,
                        'school_id' => $school_id,
                        'created_date' => NOW()
                    ]);

                    $activePayment = $this->getFeeDetails('1', $paymentCategory, $inputArray['child_school']);
                    $payableAmount = $activePayment->final_amount;
                    $paymentID = $activePayment->id;
                    $baseAmount = $activePayment->base_amount;
                    $gstAmount = ($baseAmount / 100) * $activePayment->gst_rate;

                    $serviceList = DB::select("SELECT * FROM payment_process_services WHERE payment_process_master_id = $paymentID");
                    // $taxList = DB::select("SELECT * FROM payment_process_taxes WHERE payment_process_master_id = $paymentID");

                    $response = [
                        'enrollment_child_num' => $enrollmentnum,
                        'child_id' => $claimnoticenoNew,
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_name' => $input['child_name'],
                        'initiated_by' => config('setting.email_id'),
                        'initiated_to' => $input['child_contact_email'],
                        'payment_amount' => $payableAmount,
                        'user_id' => $user_id,
                        'payment_status' => 'New',
                        'payment_process_description' => 'Kindly Pay Rs.' . $payableAmount . ' for your Registration',
                        'paymenttokentime' => '2800',
                        'enrollment_id' => $screen_permission_id1,
                        'baseAmount' => $baseAmount,
                        'gstAmount' => $gstAmount,
                        'masterData' => $response = [
                            'serviceList' => $serviceList
                        ],
                    ];
                    //Parent UAM
                    // $stringuser_id = 3;
                    // DB::table('users')
                    // 	->where('id', $user_id)
                    // 	->update([
                    // 		'array_roles' => $stringuser_id,
                    // 	]);
                    // $user_id  =  $user_id;
                    DB::table('uam_user_roles')->insertGetId([
                        'user_id' => $user_id,
                        'role_id' => 3,
                        'active_flag' => 0,
                        'created_by' => $user_id,
                        'created_date' => NOW()
                    ]);

                    $role_id = 3;
                    $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
                    $parentidcounting = count($parentrow);
                    if ($parentrow != []) {
                        for ($j = 0; $j < $parentidcounting; $j++) {
                            $module_id = $parentrow[$j]->module_id;
                            $screen_id = $parentrow[$j]->screen_id;
                            $x = 0;
                            $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
                            if ($modulesrows != []) {
                                $parent_module_id = $modulesrows[$x]->parent_module_id;
                                $module_name = $modulesrows[$x]->module_name;
                            }

                            $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
                            if ($screenrows != []) {
                                $screen_name = $screenrows[$x]->screen_name;
                                $screen_url = $screenrows[$x]->screen_url;
                                $route_url = $screenrows[$x]->route_url;
                                $class_name = $screenrows[$x]->class_name;
                                $display_order = $screenrows[$x]->display_order;
                            }

                            $check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
                            $checkcount = count($check);
                            if ($checkcount == 0) {
                                $screen_permission_id = DB::table('uam_user_screens')->insertGetId([
                                    'screen_id' => $screen_id,
                                    'module_id' => $module_id,
                                    'parent_module_id' => $parent_module_id,
                                    'module_name' => $module_name,
                                    'screen_name' => $screen_name,
                                    'screen_url' => $screen_url,
                                    'route_url' => $route_url,
                                    'class_name' => $class_name,
                                    'display_order' => $display_order,
                                    'user_id' => $user_id,
                                    'active_flag' => 0,
                                    'created_by' => $user_id,
                                    'created_date' => NOW()
                                ]);
                            }
                        };
                    };

                    $checking = DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");
                    $checkcounting = count($checking);
                    if ($checking != []) {
                        for ($k = 0; $k < $checkcounting; $k++) {
                            $screen_id = $checking[$k]->screen_id;
                            $user_screen_id = $checking[$k]->user_screen_id;

                            $permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
								inner join uam_role_screen_permissions as b on b.screen_permission_id = a.screen_permission_id
								where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

                            $permissioncheckcount = count($permissioncheck);
                            for ($m = 0; $m < $permissioncheckcount; $m++) {
                                $screen_permission_id = $permissioncheck[$m]->screen_permission_id;
                                $permission_name = $permissioncheck[$m]->permission;
                                $description = $permissioncheck[$m]->description;
                                $active_flag = $permissioncheck[$m]->active_flag;
                                $array_permission = $permissioncheck[$m]->array_permission;
                                $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
                                    'user_screen_id' =>  $user_screen_id,
                                    'screen_permission_id' =>  $screen_permission_id,
                                    'permission' => $permission_name,
                                    'description' => $description,
                                    'active_flag' => $active_flag,
                                    'array_permission' => $array_permission,
                                    'user_id' => $user_id,
                                    'created_by' => $user_id,
                                    'created_date' => NOW()
                                ]);
                            };
                        };
                    };
                    //End UAM
                    $this->auditLog('enrollment_details', $screen_permission_id, 'Create', 'New Enrollment', '', NOW(), 'Parent');
                    $this->StudentsLogs('enrollment_details', $screen_permission_id, 'Enrollment ' . $input['status'], $user_id, NOW());
                    //    // Email & System Notification
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'create a user',
                                'notification_status' => 'User enrolled',
                                'notification_url' => 'newenrollment/' . encrypt($screen_permission_id1),
                                'megcontent' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully",
                                'alert_meg' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully",
                                // 'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);

                            // $name = $admin_details[$j]->name;
                            // $email = $admin_details[$j]->email;
                            // $data = array(
                            //     'name' => $name,
                            //     'email' => $email,
                            //     'child_name' => $inputArray['child_name'],
                            //     // 'consent_form' => $inputArray['consent_form'],
                            // );
                            // Mail::to($data['email'])->send(new sendadminenrollmail($data));
                            // // dispatch(new adminenrolljob($data))->delay(now()->addSeconds(1));//Register Mail - Admin
                        }
                    }

                    $data = array(
                        // 'name' => $name,
                        // 'email' => $email,
                        'child_name' => $inputArray['child_name'],
                        // 'consent_form' => $inputArray['consent_form'],
                    );
                    // $this->WriteFileLog('asd');
                    Mail::to(config('setting.enrollment.parent'))->bcc(config('setting.enrollment.bcc'))->send(new sendadminenrollmail($data));

                    $email = $inputArray['child_contact_email'];
                    // $this->WriteFileLog('asd1');

                    $data = array(
                        'name' => $inputArray['name'],
                        'email' => $inputArray['email'],
                        'password' => $inputArray['password_confirmation'],
                    );
                    Mail::to($email)->send(new registermail($data));
                    // $this->WriteFileLog('asd3');

                    // $data = array(
                    //     'child_name' => $inputArray['child_name'],
                    //     'child_contact_email' => $inputArray['child_contact_email'],
                    //     // 'consent_form' => $inputArray['consent_form'],
                    //     'name' => $inputArray['name'],
                    //     'email' => $inputArray['email'],
                    //     'password' => $inputArray['password_confirmation'],
                    // );
                    // Mail::to($data['child_contact_email'])->send(new SendMail($data)); //Register Mail - User

                    return $response;
                });
                // Login To Portal

                $userId = $responseData['user_id'];
                $user = User::find($userId);

                $myTTL = 120; //minutes
                auth()->factory()->setTTL($myTTL);

                if (!$token = auth()->fromUser($user)) {
                    DB::table('mismatch_attempt_audit')
                        ->insertGetId([
                            'status' => 'Mismatch_Credential',
                            'email' => $request->email,
                            'password' => $request->password,
                        ]);
                    $serviceResponse = array();
                    $serviceResponse['Code'] = config('setting.status_code.unauthenticated');
                    $serviceResponse['Message'] = config('setting.status_message.unauthenticated');
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
                    return $sendServiceResponse;
                }


                if (auth()->fromUser($user)) {

                    Auth::login($user);
                    $user = auth()->user();
                    $serviceResponse1 = array();
                    $serviceResponse1['access_token'] = $token;
                    $serviceResponse1['token_type'] = 'Bearer';
                    $serviceResponse1['expires_in'] = $myTTL;
                    $serviceResponse1['user'] = auth()->user();
                } else {
                    log::error('fail');
                    $serviceResponse = array();
                    $serviceResponse['Code'] = 500;
                    $serviceResponse['Message'] = 'Not activated';
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, 500, false);
                    return $sendServiceResponse;
                }

                $token = auth()->fromUser($user);
                $payload = JWTAuth::setToken($token)->getPayload();
                $expirationTime = $payload->get('exp');
                $dateTime = Carbon::createFromTimestamp($expirationTime, 'UTC');
                $dateTime->setTimezone('Asia/Kolkata');
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

                $data = array();
                $data['hostname'] = gethostname();
                $data['formattedDateTime'] = $formattedDateTime;
                $encryhostname = $this->EncryptData($data);

                DB::table('login_audit')
                    ->insertGetId([
                        'status' => 'Login',
                        'user_id' => auth()->user()->id,
                        'login_token' => $encryhostname,
                    ]);

                $serviceResponse1['formattedDateTime'] = $formattedDateTime;
                // 
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $responseData;
                $serviceResponse['serviceResponse1'] = $serviceResponse1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
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

    public function getFeeDetails($feeType, $paymentCategory, $schoolID)
    {
        if ($paymentCategory == 2) {
            $activePayment = DB::table('payment_process_masters')
                ->where('fees_type_id', $feeType)
                ->where('category_id', $paymentCategory)
                ->where('school_enrollment_id', $schoolID)
                ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                ->first();
            if (empty($activePayment)) {
                $activePayment = DB::table('payment_process_masters')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', 1)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            }
        } else {
            $activePayment = DB::table('payment_process_masters')
                ->where('fees_type_id', $feeType)
                ->where('category_id', $paymentCategory)
                ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                ->first();
        }
        return $activePayment;
    }
}
