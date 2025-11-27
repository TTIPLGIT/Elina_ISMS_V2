<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\adminenrolljob;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class NewenrollementController extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => NewenrollementController => index';

            $userID = Auth::id();
            $authID = auth()->user()->id;
            $array_roles = DB::select("SELECT array_roles FROM users WHERE id='$userID'");
            $array_roles = $array_roles[0]->array_roles;
            $email = auth()->user()->email;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));

            // $rows = ($array_roles === '3') ? DB::select("SELECT * FROM enrollment_details WHERE enrollment_details.child_contact_email='$email'  and active_flag = '0'") : ($array_roles === '4') ? 
            // DB::select("SELECT ed.* FROM enrollment_details AS ed WHERE ed.status='Submitted' AND ed.active_flag = '0' ORDER BY ed.enrollment_id DESC") :
            // DB::select("SELECT ed.* FROM enrollment_details AS ed INNER JOIN ovm_allocation AS oa ON ed.enrollment_id=oa.enrollment_id WHERE ed.status='Submitted' AND ed.active_flag = '0' AND (oa.is_coordinator1 = $authID OR oa.is_coordinator2 = $authID) ORDER BY ed.enrollment_id DESC");
            if ($array_roles == '3') {
                $rows = DB::select("SELECT * FROM enrollment_details WHERE enrollment_details.child_contact_email='$email' and active_flag = '0'");
            } else if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT ed.* FROM enrollment_details AS ed WHERE ed.status='Submitted' AND ed.active_flag = '0' ORDER BY ed.enrollment_id DESC");
            } else {
                $rows = DB::select("SELECT ed.* FROM enrollment_details AS ed INNER JOIN ovm_allocation AS oa ON ed.enrollment_id=oa.enrollment_id WHERE ed.status='Submitted' AND ed.active_flag = '0' AND (oa.is_coordinator1 = $authID OR oa.is_coordinator2 = $authID) ORDER BY ed.enrollment_id DESC");
            }
            $sailFlag = 0;
            if (!empty($rows)) {
                if ($array_roles == '3') {
                    $enrollmentID = $rows[0]->enrollment_child_num;
                    $sail = DB::select("SELECT * FROM sail_details WHERE enrollment_id = '$enrollmentID' AND consent_aggrement IS NULL AND current_status NOT LIKE '%Will%' ");
                    if (!empty($sail)) {
                        $sailFlag = 1;
                    }
                }
            }


            $response = [
                'rows' => $rows,
                'sailFlag' => $sailFlag,
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
    //
    //create

    public function internlist(Request $request)
    {
        try {

            $method = 'Method => NewenrollementController => internlist';

            $rows = DB::select("SELECT * FROM internship_application_form 
            WHERE agreement = 'Agreed' ORDER BY internship_id DESC ");
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
    public function servicelist(Request $request)
    {
        try {

            $method = 'Method => NewenrollementController => Service Provider';


            $rows = DB::select("SELECT * FROM service_provider WHERE agree_of_acknowledgement = 'Agreed' ORDER BY id DESC ");

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
            $method = 'Method => NewenrollementController => createdata';

            $id = auth()->user()->id;
            $email = DB::select("select * from users where id = $id");
            $rows = DB::select("select * from enrollment_details WHERE user_id =$id AND active_flag=0");
            $consent = DB::select("SELECT * FROM policy_publish WHERE id=3 ");
            $response = [
                'rows' => $rows,
                'email' => $email,
                'consent' => $consent
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




    //store

    public function storedata(Request $request)
    {

        //return $request;
        try {
            $method = 'Method => NewenrollementController => storedata';



            $inputArray = $this->decryptData($request->requestData);

            // return $inputArray;

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
                'consent_form' => $inputArray['consent_form'],
                'child_alter_phone' => $inputArray['child_alter_phone'],
                'consent_aggrement' => $inputArray['consent_aggrement'],
            ];



            $services_from_elina = json_encode($input['services_from_elina'], JSON_FORCE_OBJECT);
            $how_knowabt_elina = json_encode($input['how_knowabt_elina'], JSON_FORCE_OBJECT);

            $child_contact_email = $input['child_contact_email'];
            // $this->WriteFileLog($child_contact_email);

            $user_check = DB::select("select * from enrollment_details where child_contact_email = '$child_contact_email' and active_flag = 0");
            // $this->WriteFileLog($user_check);
            // $this->WriteFileLog($user_check== []);

            if ($user_check == []) {



                $response1 = DB::transaction(function () use ($input) {
                    $authID = Auth::id();
                    $services = $input['services_from_elina'];
                    $know_about = $input['how_knowabt_elina'];
                    $services_from_elina = json_encode($services, JSON_FORCE_OBJECT);
                    $how_knowabt_elina = json_encode($know_about, JSON_FORCE_OBJECT);
                    $claimdetails = DB::table('enrollment_details')->orderBy('enrollment_id', 'desc')->first();

                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'CH/' . date("Y") . '/001';
                        $enrollmentnum    =  'EN/' . date("Y") . '/' . date("m") . '/001';
                    }
                    // else {
                    //     $claimnoticeno = $claimdetails->child_id;
                    //     $claimnoticenoNew =  ++$claimnoticeno;  // AAA004 
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
                    $inputArraycount = count($input);

                    $screen_permission_id = DB::table('enrollment_details')->insertGetId([
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
                        'status' => $input['status'],
                        'active_flag' => 0,
                        'child_id' => $claimnoticenoNew,
                        'user_id' => $authID,
                        'created_by' => $authID,
                        'consent_aggrement' => $input['consent_aggrement'],
                        'created_date' => NOW()
                    ]);
                    $this->updateGoogleEvent();
                    $payment = DB::select("select * from payment_structure where fees_type='enroll' and status='active'");

                    $response = [
                        'enrollment_child_num' => $enrollmentnum,
                        'child_id' => $claimnoticenoNew,
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_name' => $input['child_name'],
                        'initiated_by' => config('setting.email_id'),
                        'initiated_to' => $input['child_contact_email'],
                        'payment_amount' => $payment[0]->amount,
                        'user_id' => $authID,
                        'payment_status' => 'New',
                        'payment_process_description' => 'Kindly Pay Rs.' . $payment[0]->amount . ' for your Registration',
                        'paymenttokentime' => '2800',
                    ];

                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");

                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('enrollment_details', $screen_permission_id, 'Create', 'create new enrollment', $authID, NOW(), $role_name_fetch);
                    // $this->notificationstable( $input['child_name'], 'Enrolled', ' Create a Enrollment', ' User Enrolled successfully');
                    $m = $input['status'];
                    if ($m == 'Submitted') {
                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => $authID,
                            'notification_type' => 'create a user',
                            'notification_status' => 'User enrolled',
                            'notification_url' => 'newenrollment/' .  encrypt($screen_permission_id),
                            'megcontent' => $input['child_name'] . " (" . $enrollmentnum . ")" . " Successfully Enrolled with Elina.",
                            'alert_meg' => $input['child_name'] . " (" . $enrollmentnum . ")" . " Successfully Enrolled with Elina.",
                            'created_by' => $authID,
                            'created_at' => NOW()
                        ]);

                        $admin_details = DB::SELECT("SELECT *from users where array_roles = '4'");
                        $adminn_count = count($admin_details);
                        if ($admin_details != []) {
                            for ($j = 0; $j < $adminn_count; $j++) {

                                DB::table('notifications')->insertGetId([
                                    'user_id' =>  $admin_details[$j]->id,
                                    'notification_type' => 'create a user',
                                    'notification_status' => 'User enrolled',
                                    'notification_url' => 'newenrollment/' .  encrypt($screen_permission_id),
                                    'megcontent' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully and Consent Form Sent",
                                    'alert_meg' => "User " . $input['child_name'] . " (" . $enrollmentnum . ")" .  " Enrolled Successfully and Consent Form Sent",
                                    'created_by' => $authID,
                                    'created_at' => NOW()
                                ]);

                                $email = $admin_details[$j]->email;
                                $data = array(
                                    'admin' => $admin_details[$j]->name,
                                    'name' => $input['child_father_guardian_name'],
                                    'email' => $email,
                                    'child_name' => $input['child_name'],
                                    'consent_form' => $input['consent_form'],
                                );

                                dispatch(new adminenrolljob($data))->delay(now()->addSeconds(30));
                            }
                        }
                    }
                    return $response;
                });
                $email = $inputArray['child_contact_email'];
                $data = array(
                    'child_name' => $inputArray['child_name'],
                    'child_contact_email' => $inputArray['child_contact_email'],
                    'consent_form' => $inputArray['consent_form'],
                    'status' => $input['status']
                );

                $m = $input['status'];
                if ($m == 'Submitted') {
                    Mail::to($data['child_contact_email'])->send(new SendMail($data));
                }

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $response1;
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


    public function data_edit($id)
    {
        try {
            $method = 'Method => NewenrollementController => data_edit';
            $id = $this->DecryptData($id);
            $rows = DB::table('enrollment_details as a')->select('a.*')->where('a.enrollment_id', $id)->get();

            $consent = DB::select("SELECT * FROM policy_publish WHERE id=3 ");
            $authID = auth()->user()->id;
            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
            $role = $roleGet[0]->role_name;
            if ($role == 'Parent') {
                $enrollment_child_num = $rows[0]->enrollment_child_num;
                $sailD = DB::select("SELECT * FROM sail_details WHERE enrollment_id = '$enrollment_child_num'");
                $ovm = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE enrollment_id = '$enrollment_child_num' and STATUS = 'Completed'");
                $ovm2 = DB::select("SELECT * FROM ovm_meeting_2_details WHERE enrollment_id='$enrollment_child_num' AND meeting_status = 'Completed'");
                $sail = 1;
                if ($sailD == []) {
                    $sail = 0;
                }
                if ($ovm == []) {
                    $sail = 1;
                }
                if ($ovm2 == []) {
                    $sail = 1;
                }
            } else {
                $sail = 1;
            }
            $response = [
                'rows' => $rows,
                'consent' => $consent,
                'sail' => $sail,
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
    public function internview_data_edit($id)
    {
        try {

            $method = 'Method => NewenrollementController => Intern view data edit';
            // $this->WriteFileLog($method);
            $id = $this->DecryptData($id);
            $rows = DB::table('internship_application_form as a')->select('a.*')->where('a.internship_id', $id)->get();
            // $this->WriteFileLog($id);
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

    public function serviceproviderview_data_edit($id)
    {
        try {

            $method = 'Method => NewenrollementController => serviceprovider view data edit';
            // $this->WriteFileLog($method);
            $id = $this->DecryptData($id);
            $rows = DB::table('service_provider as a')
                ->select('a.*')
                ->where('a.id', $id)
                ->get();
            // $this->WriteFileLog($id);
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
            $method = 'Method =>  NewenrollementController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
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
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'consent_form' => $inputArray['consent_form'],
                'child_alter_phone' => $inputArray['child_alter_phone'],
                'consent_aggrement' => $inputArray['consent_aggrement'],
            ];

            $response1 = DB::transaction(function () use ($input) {
                $btn = $input['status'];
                $authID = Auth::id();
                $services = $input['services_from_elina'];
                $know_about = $input['how_knowabt_elina'];
                $services_from_elina = json_encode($services, JSON_FORCE_OBJECT);
                $how_knowabt_elina = json_encode($know_about, JSON_FORCE_OBJECT);
                if ($btn == 'Submitted') {
                    DB::table('enrollment_details')
                        ->where('enrollment_id', $input['id'])
                        ->update([
                            'enrollment_child_num' => $input['enrollment_child_num'],
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
                            'status' => $input['status'],
                            'consent_aggrement' => $input['consent_aggrement'],
                            'child_alter_phone' => $input['child_alter_phone'],
                            'active_flag' => 0,
                            'flag' => 1,
                            'user_id' => $authID,
                            'created_by' => $authID,
                            'created_date' => NOW()
                        ]);
                } else if ($btn == 'Declined') {
                    DB::table('enrollment_details')
                        ->where('enrollment_id', $input['id'])
                        ->update([
                            'enrollment_child_num' => $input['enrollment_child_num'],
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
                            'status' => $input['status'],
                            'consent_aggrement' => 'Declined',
                            'child_alter_phone' => $input['child_alter_phone'],
                            'active_flag' => 0,
                            'user_id' => $authID,
                            'created_by' => $authID,
                            'created_date' => NOW()
                        ]);
                } else {
                    DB::table('enrollment_details')
                        ->where('enrollment_id', $input['id'])
                        ->update([
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
                            'last_modified_by' => $authID,
                            'last_modified_date' => NOW()
                        ]);
                }

                $id = $input['id'];
                $enrollmentDB = DB::select("select * from enrollment_details where enrollment_id=$id");
                $this->updateGoogleEvent();
                $payment = DB::select("select * from payment_structure where fees_type='enroll' and status='Active' ");

                $response = [
                    'enrollment_child_num' => $enrollmentDB[0]->enrollment_child_num,
                    'child_id' => $enrollmentDB[0]->child_id,
                    'child_father_guardian_name' => $enrollmentDB[0]->child_father_guardian_name,
                    'child_name' => $enrollmentDB[0]->child_name,
                    'initiated_by' => config('setting.email_id'),
                    'initiated_to' => $enrollmentDB[0]->child_contact_email,
                    'payment_amount' => $payment[0]->amount,
                    'user_id' => $authID,
                    'payment_status' => 'New',
                    'payment_process_description' => 'Kindly Pay Rs.' . $payment[0]->amount . ' for your Registration',
                    'paymenttokentime' => '2800',
                ];

                $m = $input['status'];
                $screen_permission_id = $input['id'];
                $enrollmentnum = $input['enrollment_child_num'];
                if ($m == 'Submitted') {
                    DB::table('notifications')->insertGetId([
                        'user_id' => $authID,
                        'notification_type' => 'create a user',
                        'notification_status' => 'User enrolled',
                        'notification_url' => 'newenrollment/' .  encrypt($screen_permission_id),
                        'megcontent' => $input['child_name'] . " (" . $enrollmentnum . ")" . " successfully Enrolled with Elina.",
                        'alert_meg' => $input['child_name'] . " (" . $enrollmentnum . ")" . " successfully Enrolled with Elina.",
                        'created_by' => $authID,
                        'created_at' => NOW()
                    ]);
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);

                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'create a user',
                                'notification_status' => 'User enrolled',
                                'notification_url' => 'newenrollment/' .  encrypt($screen_permission_id),
                                'megcontent' => "User " . $input['child_name'] . "(" . $enrollmentnum . ")" .  " Enrolled Successfully and Consent Form Sent",
                                'alert_meg' => "User " . $input['child_name'] . "(" . $enrollmentnum . ")" .  " Enrolled Successfully and Consent Form Sent",
                                'created_by' => $authID,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                } else if ($m == 'Declined') {

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);

                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'create a user',
                                'notification_status' => 'User enrolled',
                                'notification_url' => 'newenrollment/' .  encrypt($screen_permission_id),
                                'megcontent' => "User " . $input['child_name'] . "(" . $enrollmentnum . ")" .  " has Declined the Enrolled Consent Form",
                                'alert_meg' => "User " . $input['child_name'] . "(" . $enrollmentnum . ")" .  " has Declined the Enrolled Consent Form",
                                'created_by' => $authID,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                }

                $data = array(
                    'child_name' => $input['child_name'],
                    'child_contact_email' => $input['child_contact_email'],
                    'consent_form' => $input['consent_form'],
                    'status' => $input['status']

                );
                $m = $input['status'];
                $consent_aggrement = $input['consent_aggrement'];
                if ($m == 'Submitted' && $consent_aggrement != 'Agreed') {
                    Mail::to($data['child_contact_email'])->send(new SendMail($data));
                }

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $role_name_fetch = $role_name[0]->role_name;

                $this->auditLog('enrollment_details', $screen_permission_id, 'Create', 'create new enrollment', $authID, NOW(), $role_name_fetch);
                $this->StudentsLogs('enrollment_details', $screen_permission_id, 'Enrollment ' . $input['status'], $authID, NOW());
                return $response;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response1;
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

    public function updatedata_v2(Request $request)
    {

        try {
            $method = 'Method =>  NewenrollementController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
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
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'consent_form' => $inputArray['consent_form'],
                'child_alter_phone' => $inputArray['child_alter_phone'],
                'consent_aggrement' => $inputArray['consent_aggrement'],
            ];

            $response1 = DB::transaction(function () use ($input) {

                $authID = Auth::id();
                $services = $input['services_from_elina'];
                $know_about = $input['how_knowabt_elina'];
                $services_from_elina = json_encode($services, JSON_FORCE_OBJECT);
                $how_knowabt_elina = json_encode($know_about, JSON_FORCE_OBJECT);

                $originalDate = $input['child_dob'];
                $formattedDate = Carbon::parse($originalDate)->format('d/m/Y');

                DB::table('enrollment_details')
                    ->where('enrollment_id', $input['id'])
                    ->update([
                        'child_name' => $input['child_name'],
                        'child_dob' => $formattedDate,
                        'child_school_name_address' => $input['child_school_name_address'],
                        'child_gender' => $input['child_gender'],
                        'child_father_guardian_name' => $input['child_father_guardian_name'],
                        'child_mother_caretaker_name' => $input['child_mother_caretaker_name'],
                        'child_contact_email' => $input['child_contact_email'],
                        'child_contact_phone' => $input['child_contact_phone'],
                        'child_contact_address' => $input['child_contact_address'],
                        'child_alter_phone' => $input['child_alter_phone'],
                        'services_from_elina' => $services_from_elina,
                        'how_knowabt_elina' => $how_knowabt_elina,
                        'last_modified_by' => $authID,
                        'last_modified_date' => NOW()
                    ]);

                DB::table('users')
                    ->where('id', $authID)
                    ->update([
                        'name' => $input['child_name'],
                        'Mobile_no' => $input['child_contact_phone'],
                        'active_flag' => 0,
                        'updated_at' => now(),
                    ]);

                $screen_permission_id = $input['id'];
                $enrollmentnum = $input['enrollment_child_num'];
                $childInfo = "{$input['child_name']} ({$enrollmentnum})";

                $admins = DB::table('users')
                    ->where('array_roles', 4)
                    ->get();

                $notificationUrl = 'newenrollment/' . encrypt($screen_permission_id);
                $childInfo = "{$input['child_name']} ({$enrollmentnum})";

                foreach ($admins as $admin) {
                    DB::table('notifications')->insert([
                        'user_id' => $admin->id,
                        'notification_type' => 'update enrollment',
                        'notification_status' => 'Enrollment updated',
                        'notification_url' => $notificationUrl,
                        'megcontent' => "Enrollment details for $childInfo have been updated.",
                        'alert_meg' => "Enrollment details for $childInfo have been updated.",
                        'created_by' => $authID,
                        'created_at' => now(),
                    ]);
                }

                $role = DB::table('uam_roles as ur')
                    ->join('users as us', 'us.array_roles', '=', 'ur.role_id')
                    ->where('us.id', $authID)
                    ->value('role_name');

                // Log actions
                $this->auditLog(
                    'enrollment_details',
                    $screen_permission_id,
                    'Update',
                    'Enrollment details updated',
                    $authID,
                    now(),
                    $role
                );

                $this->StudentsLogs(
                    'enrollment_details',
                    $screen_permission_id,
                    'Enrollment ' . $input['status'],
                    $authID,
                    now()
                );

                return true;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response1;
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


    public function data_delete($id)
    {
        // $this->WriteFileLog("hjgjf");
        try {


            $method = 'Method =>NewenrollementController => data_delete';
            // $this->WriteFileLog($method);
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);



            $check = DB::select("select * from enrollment_details where enrollment_id = '$id' and active_flag = '0' ");
            // $this->WriteFileLog($check);
            if ($check !== []) {

                // $this->WriteFileLog($check);
                DB::table('enrollment_details')
                    ->where('enrollment_id', $id)
                    ->update([
                        'active_flag' => 1,

                    ]);



                // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //     INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                // $role_name_fetch=$role_name[0]->role_name;

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
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

        //
    }

    public function syj_getdata($id)
    {
        try {
            $method = 'Method => NewenrollementController => syj_getdata';
            $id = $this->DecryptData($id);
            $rows = DB::table('webportal_may_help_you')->select('*')->where('id', $id)->get();

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
}
