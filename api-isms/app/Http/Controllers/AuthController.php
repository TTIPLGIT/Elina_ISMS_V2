<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\registermailjob;

use App\Mail\registermail;
use App\Mail\adminregistermail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\User;
use App\Jobs\CheckRemainder;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use App\Jobs\LoginJob;
use App\Mail\MultipleLogin;

class AuthController extends BaseController
{
	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/
	public function register()
	{
		// $this->WriteFileLog("sj");
		$serviceResponse = array();
		// $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.not_found'), false);
		return $serviceResponse;
	}

	public function checkSession()
	{
		// return "200";
		// $this->WriteFileLog("checkSession");
		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.success');
		$serviceResponse['Message'] = config('setting.status_message.success');
		$serviceResponse['Data'] = 1;
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}

	public function registerstore(Request $request)
	{
		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);

			$data['name'] = $request->name;
			$data['email'] = $request->email;
			$data['password'] = bcrypt($request->password);
			$password = $request->password;
			$data['password_confirmation'] = $request->password_confirmation;
			$data['Mobile_no'] = $request->Mobile_no;
			$data['dor'] = $request->dor;
			$input = [
				'name' => $inputArray['name'],
				'email' => $inputArray['email'],
				'password' => $inputArray['password'],
				'Mobile_no' => $inputArray['Mobile_no'],
				'dor' => $inputArray['dor'],
			];

			$email = $input['email'];
			$email_check = DB::select("select * from users where email = '$email'");
			if (json_encode($email_check) == '[]') {

				DB::transaction(function () use ($input, $email, $inputArray) {
					$user_id = DB::table('users')
						->insertGetId([
							'name' => $input['name'],
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
							'array_roles' => '3',
							'profile_image' => '/images/profile-picture.webp',
						]);

					$enrollment = DB::select("select * from enrollment_details WHERE child_contact_email='$email' ORDER BY created_date DESC ");

					if (json_encode($enrollment) != '[]') {

						$enrolledID = $enrollment[0]->enrollment_id;
						DB::table('enrollment_details')
							->where('enrollment_id', $enrolledID)
							->update([
								'user_id' => $user_id,
								'status' => 'Submitted'
							]);
					}

					$data = array(
						'name' => $inputArray['name'],
						'email' => $inputArray['email'],
						'password' => $inputArray['password_confirmation'],
					);

					Mail::to($email)->send(new registermail($data));
					// dispatch(new registermailjob($data))->delay(now()->addSeconds(1));

					// $stringuser_id = 3;
					// $update_id =  DB::table('users')
					// 	->where('id', $user_id)
					// 	->update([
					// 		'array_roles' => $stringuser_id,
					// 	]);
					// $user_id  =  $user_id;
					DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => '3',
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
							if ($checkcount == '') {
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

					if (json_encode($enrollment) != '[]') {
						$enrolledID = $enrollment[0]->enrollment_id;
						DB::delete("DELETE from uam_user_screens where route_url='newenrollment/create' AND user_id =$user_id");

						$user_screen = DB::select("SELECT * from uam_user_screens as a where  a.route_url = 'newenrollment' AND a.user_id=$user_id");
						if (json_encode($user_screen) != '[]') {
							$user_screen_id = $user_screen[0]->user_screen_id;
							DB::delete("DELETE from uam_user_screen_permissions where user_screen_id=$user_screen_id AND permission = 'Delete'");
						}
					}
				});


				$email = $inputArray['email'];
				$users = DB::select("SELECT email, name from users where array_roles='4'");
				$email = $users[0]->email;
				$admin_email = count($users);

				if ($email != []) {
					for ($j = 0; $j < $admin_email; $j++) {

						$name = $users[$j]->name;
						$data = array(
							'admin' => $name,
							'name' => $input['name'],
						);
						Mail::to($users[$j]->email)->send(new adminregistermail($data));
					}
				}

				//   $this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				// $this->WriteFileLog('a');
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


	public function signedLogin(Request $request)
	{
		$logMethod = 'AuthController => signedLogin';
		try {
			$decrypted = decrypt($request['requestData']);
			//  $this->WriteFileLog($decrypted);
			$userId = $decrypted['id'];
			$user = User::find($userId);
			// $this->WriteFileLog($user);

			$myTTL = 120; //minutes
			auth()->factory()->setTTL($myTTL);

			if (!$token = auth()->fromUser($user)) {
				// $this->WriteFileLog($token);

				$login_audit = DB::table('mismatch_attempt_audit')
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
				// $this->WriteFileLog($token);
				Auth::login($user);
				$user = auth()->user();
				$serviceResponse = array();
				$serviceResponse['access_token'] = $token;
				$serviceResponse['token_type'] = 'Bearer';
				$serviceResponse['expires_in'] = $myTTL;
				$serviceResponse['user'] = auth()->user();
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
			$data['hostname'] = $request->header('x-custome-cookie');
			$data['formattedDateTime'] = $formattedDateTime;
			$data['token'] = $token;
			$data['activeCheck'] = auth()->user()->online;
			$encryhostname = $this->EncryptData($data);

			$login_audit = DB::table('login_audit')
				->insertGetId([
					'status' => 'Login',
					'user_id' => auth()->user()->id,
					'login_token' => $encryhostname,
				]);

			DB::table('users')->where('id', auth()->user()->id)->update(['online' => 1]);
			// dispatch(new LoginJob(auth()->user()->id))->delay(now()->addMinutes(120));


			$serviceResponse['formattedDateTime'] = $formattedDateTime;

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

	public function Login(Request $request)
	{
		$logMethod = 'AuthController => Login';
		try {
			// $this->WriteFileLog($logMethod);
			$input = [
				'email' => $request->email,
				'password' => $request->password,
			];

			$rules = [
				'email' => 'required|email',
				'password' => 'required',
			];

			$messages = [
				'email.required' => 'Email ID is required',
			];

			$validator = Validator::make($input, $rules, $messages);

			$email = $request->email;
			$password = $request->password;
			if ($validator->fails()) {
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.validation');
				$serviceResponse['Message'] = $validator->errors()->first();
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), false);
				return $sendServiceResponse;
			}
			// $this->WriteFileLog(auth()->attempt(['email' => $email, 'password' => $password]));
			$credentials = $request->only('email', 'password', 'active_flag');

			if (!$token = auth()->attempt(['email' => $email, 'password' => $password, 'delete_status' => '0'])) {
				$login_audit = DB::table('mismatch_attempt_audit')
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
			$hostname = $request->browserUuid;
			$activeCheck1 = 0;

			$activeCheck = auth()->user()->online;
			if ($activeCheck == 1) {
				$userID = auth()->user()->id;
				$activeCheck1 = 1;
				$get_data = DB::select("SELECT login_time , audit_id , login_token FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 2");
				if ($get_data != []) {
					$last_token = $get_data[0]->login_token;
					$tk = $this->DecryptData($last_token);
					if (isset($tk['token'])) {
						$last_accessKey = $tk['token'];
						$dec_hostname = $tk['hostname'];
						if (isset($get_data[1])) {
							$last_token1 = $get_data[1]->login_token;
							$decrytoken1 = $this->DecryptData($last_token1);
							if (isset($decrytoken1['token'])) {
								$last_accessKey1 = $decrytoken1['token'];
							}
							$last_accessKey1 = '';
						} else {
							$last_accessKey1 = '';
						}

						if ($last_accessKey != $last_accessKey1) {
							$activeMail = auth()->user()->email;
							$activeData = array(
								'mail' => $activeMail,
							);
							$userID = auth()->user()->array_roles;
							if ($userID != 3) {
								Mail::to($activeMail)->send(new MultipleLogin($activeData));
							}
						}
					}
				}
			} else {
				DB::table('users')->where('id', auth()->user()->id)->update(['online' => 1]);
				// dispatch(new LoginJob(auth()->user()->id))->delay(now()->addMinutes(120));
			}

			$user = auth()->user();
			$serviceResponse = array();
			$serviceResponse['access_token'] = $token;
			$serviceResponse['token_type'] = 'Bearer';
			$serviceResponse['expires_in'] = auth()->factory()->getTTL() * 120;
			$serviceResponse['user'] = auth()->user();


			// Login Token & Time

			// $token = auth()->attempt(['email' => $email, 'password' => $password]);
			// $payload = JWTAuth::setToken($token)->getPayload();
			// $expirationTime = $payload->get('exp');
			// $dateTime = Carbon::createFromTimestamp($expirationTime, 'UTC');
			// $dateTime->setTimezone('Asia/Kolkata');
			// $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

			$payload = JWTAuth::setToken(auth()->attempt(['email' => $email, 'password' => $password]))->getPayload();
			$formattedDateTime = Carbon::createFromTimestamp($payload->get('exp'), 'UTC')->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s');

			$data = array();
			$data['hostname'] = $hostname;
			$data['formattedDateTime'] = $formattedDateTime;
			$data['token'] = $token;
			$data['activeCheck'] = $activeCheck1;
			$encryhostname = $this->EncryptData($data);

			$login_audit = DB::table('login_audit')
				->insertGetId([
					'status' => 'Login',
					'user_id' => auth()->user()->id,
					'login_token' => $encryhostname,
				]);

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




	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/
	public function NotFound()
	{
		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.not_found');
		$serviceResponse['Message'] = config('setting.status_message.not_found');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.not_found'), false);
		return $sendServiceResponse;
	}

	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Testing the server status.
	 **/
	public function ServerTest()
	{
		$serviceResponse = array();
		$serviceResponse['Code'] = 200;
		$serviceResponse['Message'] = 'Server is up and running.';
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}

	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Unauthenticated user.
	 **/
	public function Unauthenticated()
	{

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
		return $sendServiceResponse;
	}

	//KD
	public function logout()
	{
		$userID = auth()->user()->id;
		$get_data = DB::select("SELECT  audit_id FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 1");

		$last_id = $get_data[0]->audit_id;

		DB::table('login_audit')
			->where([['user_id', '=', auth()->user()->id], ['audit_id', '=', $last_id]])
			->update([
				'status1' => 'logout'
			]);

		DB::table('users')->where('id', auth()->user()->id)->update(['online' => 0]);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	public function user_unauthenticate(Request $request, $id)
	{

		$userID = $this->decryptData($id);
		// $this->WriteFileLog($userID);
		$get_data = DB::select("SELECT  audit_id FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 1");
		$last_id = $get_data[0]->audit_id;

		DB::table('login_audit')
			->where([['user_id', '=', $userID], ['audit_id', '=', $last_id]])
			->update(['status1' => 'logout']);

		DB::table('users')->where('id', $userID)->update(['online' => 0]);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	public function require_captcha(Request $request)
	{
		$inputArray = $this->decryptData($request->requestData);

		$input = [
			'email' => $inputArray['email'],
			'password' => $inputArray['password'],
		];





		// $login_audit=DB::table('mismatch_attempt_audit')
		// ->insertGetId([

		// 	'status' => 'Captcha Required',
		// 	'email'=>$input['email'],
		// 	'password'=>$input['password'],



		// ]);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.require_captcha');
		$serviceResponse['Message'] = config('setting.status_message.require_captcha');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	//KD

	public function signedLoginSub(Request $request)
	{
		$logMethod = 'AuthController => signedLogin';
		try {
			$decrypted = decrypt($request['requestData']);
			$userId = $decrypted['id'];
			$user = User::find($userId);
			$myTTL = 120;
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
				// $this->WriteFileLog($token);
				Auth::login($user);
				$user = auth()->user();
				$serviceResponse = array();
				$serviceResponse['access_token'] = $token;
				$serviceResponse['token_type'] = 'Bearer';
				$serviceResponse['expires_in'] = $myTTL;
				$serviceResponse['user'] = auth()->user();
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
			// $this->WriteFileLog($formattedDateTime);

			$data = array();
			$data['hostname'] = $request->header('x-custome-cookie');
			$data['formattedDateTime'] = $formattedDateTime;
			$data['token'] = $token;
			$data['activeCheck'] = auth()->user()->online;
			$encryhostname = $this->EncryptData($data);

			$login_audit = DB::table('login_audit')
				->insertGetId([
					'status' => 'Login',
					'user_id' => auth()->user()->id,
					'login_token' => $encryhostname,
				]);

			DB::table('users')->where('id', auth()->user()->id)->update(['online' => 1]);
			// dispatch(new LoginJob(auth()->user()->id))->delay(now()->addMinutes(120));


			$serviceResponse['formattedDateTime'] = $formattedDateTime;

			// $data = [
			// 	'status' => 'Login',
			// 	'name' => $user->name,
			// 	'date' => now(),
			// ];

			// Mail::to($email)->send(new SendLogin($data));
			// KD

			$Response = DB::select("SELECT a.child_father_guardian_name, a.enrollment_id , a.enrollment_child_num , a.child_name , a.child_id , a.category_id, a.school_id,
			JSON_EXTRACT(b.is_coordinator1, '$.id') AS is_coordinator1 , JSON_EXTRACT(b.is_coordinator2, '$.id') AS is_coordinator2 , a.user_id FROM enrollment_details AS a
			INNER JOIN ovm_meeting_details AS b ON b.enrollment_id = a.enrollment_child_num
			WHERE a.user_id = " . auth()->user()->id);
			// 
			$feeType = 2;
			$payableAmount = $this->getPayableAmount($Response[0]->enrollment_id, $feeType);
			$ResponseData = [
				'enrollment_id' => $Response[0]->enrollment_id,
				'enrollment_child_num' => $Response[0]->enrollment_child_num,
				'child_name' => $Response[0]->child_name,
				'childGuardianName' => $Response[0]->child_father_guardian_name,
				'child_id' => $Response[0]->child_id,
				'is_coordinator1' => $Response[0]->is_coordinator1,
				'is_coordinator2' => $Response[0]->is_coordinator2,
				'user_id' => $Response[0]->user_id,
				'payableAmount' => $payableAmount
			];
			$serviceResponse['ResponseData'] = $ResponseData;
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

	public function signedLoginSail(Request $request)
	{
		$logMethod = 'AuthController => signedLoginSail';
		try {
			$decrypted = decrypt($request['requestData']);
			$userId = $decrypted['id'];
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
				$serviceResponse = array();
				$serviceResponse['access_token'] = $token;
				$serviceResponse['token_type'] = 'Bearer';
				$serviceResponse['expires_in'] = $myTTL;
				$serviceResponse['user'] = auth()->user();
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
			// $this->WriteFileLog($formattedDateTime);

			$data = array();
			$data['hostname'] = $request->header('x-custome-cookie');
			$data['formattedDateTime'] = $formattedDateTime;
			$data['token'] = $token;
			$data['activeCheck'] = auth()->user()->online;
			$encryhostname = $this->EncryptData($data);

			$login_audit = DB::table('login_audit')
				->insertGetId([
					'status' => 'Login',
					'user_id' => auth()->user()->id,
					'login_token' => $encryhostname,
				]);

			DB::table('users')->where('id', auth()->user()->id)->update(['online' => 1]);
			// dispatch(new LoginJob(auth()->user()->id))->delay(now()->addMinutes(120));

			$serviceResponse['formattedDateTime'] = $formattedDateTime;

			$Response = DB::select("SELECT * FROM enrollment_details WHERE user_id =" . auth()->user()->id);
			$enrollmentID = $Response[0]->enrollment_child_num;
			$Response1 = DB::select("SELECT current_status,consent_aggrement FROM sail_details WHERE enrollment_id = '$enrollmentID'");

			$serviceResponse['ResponseData'] = $Response;
			$serviceResponse['ResponseDetails'] = $Response1;
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
}
