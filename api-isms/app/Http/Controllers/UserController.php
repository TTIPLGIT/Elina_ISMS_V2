<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendResetMail;
use App\Mail\SendUserCreateMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;
use App\Googl;
use Illuminate\Support\Facades\Date;
use App\Mail\userupdateemail;


class UserController extends BaseController
{
	public function expcreate()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$this->WriteFileLog('a');
			$userID = (auth()->check()) ? auth()->user()->id : 's';
			// $userID = Auth::user();
			$this->WriteFileLog('b');
			$this->WriteFileLog($userID);


			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $userID;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
		} catch (\Exception $exc) {
			$this->WriteFileLog('er');
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
	public function educreate()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$this->WriteFileLog('a');
			$userID = (auth()->check()) ? auth()->user()->id : 's';
			// $userID = Auth::user();
			$this->WriteFileLog('b');
			$this->WriteFileLog($userID);

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $userID;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
		} catch (\Exception $exc) {
			$this->WriteFileLog('er');
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
	public function registerapl(Request $request)
	{
		$logMethod = 'Method => UserController => User';

		try {
			$this->WriteFileLog('a');
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$this->WriteFileLog($request, 'qwqw');
			// $userID = Auth::user();
			$this->WriteFileLog('b');
			$this->WriteFileLog($userID);
			$rows = array();
			$rows['general'] = DB::table('user_general_details')
				->select('*')
				->where('user_id', $userID)
				->get();
			$rows['questionmaster'] = DB::table('question_master')
				->select('*')
				->get();
			$rows['usereq'] = DB::table('user_eligible_qa_details')
				->select('*')
				->rightJoin('question_master', 'user_eligible_qa_details.qid', '=', 'question_master.id')
				->where([['user_eligible_qa_details.user_id', $userID], ['user_eligible_qa_details.active_flag', "0"]])
				->get();
			$rows['educationstate'] = DB::table('user_education_details')
				->select('*')
				->where('user_id', $userID)
				->get();
			$this->WriteFileLog($rows['educationstate']);
			$rows['education']['ug'] = DB::table('user_education_details')
				->select('user_education_ug_details.*')
				->leftJoin('user_education_ug_details', 'user_education_ug_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();
			$rows['education']['pg'] = DB::table('user_education_details')
				->select('user_education_pg_details.*')
				->leftJoin('user_education_pg_details', 'user_education_pg_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();
			$rows['education']['dip'] = DB::table('user_education_details')
				->select('user_education_dip_details.*')
				->leftJoin('user_education_dip_details', 'user_education_dip_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();
			$rows['Experience']['index'] = DB::table('user_exp_details')
				->select('*')
				->where('user_id', $userID,)
				->get();
			$rows['check'] = DB::table('user_exp_details')
				->select('wrqch')
				->where('user_id', $userID)
				->get();
			$check = $rows['check'];
			if ($check == "yes") {
				$rows['Experience']['wrq'] = DB::table('user_exp_details')
					->select('user_exp_wrq_details.*')
					->leftJoin('user_exp_wrq_details', 'user_exp_wrq_details.uexid', '=', 'user_exp_details.id')
					->where('user_exp_details.user_id', $userID)
					->get();
			} else {
				$rows['Experience']['wre'] = DB::table('user_exp_details')
					->select('user_exp_wre_details.*')
					->leftJoin('user_exp_wre_details', 'user_exp_wre_details.uexid', '=', 'user_exp_details.id')
					->where('user_exp_details.user_id', $userID)
					->get();
			}

			$rows['Experience']['cert'] = DB::table('user_exp_details')
				->select('user_exp_cert_details.*')
				->leftJoin('user_exp_cert_details', 'user_exp_cert_details.uexid', '=', 'user_exp_details.id')
				->where('user_exp_details.user_id', $userID)
				->get();

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $rows;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
		} catch (\Exception $exc) {
			$this->WriteFileLog('er');
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
	public function generalstore(Request $request)
	{
		$this->WriteFileLog('surfh');
		$this->WriteFileLog($request);

		try {
			$method = 'Method => General_registation => storedata';
			$inputArray = $request->requestData;
			$this->WriteFileLog($inputArray);
			// 		  $data['fname'] = $request->fname;
			// 		  $data['lname'] = $request->lname;
			// 		  $data['gender'] = $request->gender;
			// 		  $data['Address_line1'] = $request->Address_line1;
			// 	  $data['consistueny'] = $request->consistueny;
			// 	  $data['providence'] = $request->providence;
			// 	  $data['email'] = $request->email;
			// 	  $data['mobile_no'] = $request->mobile_no;
			// 	  $data['nin'] = $request->nin;
			//   $data['passport'] = $request->passport;

			$input = [
				'fname' => $inputArray['fname'],
				'lname' => $inputArray['lname'],
				'gender' => $inputArray['gender'],
				'Address_line1' => $inputArray['Address_line1'],
				'district' => $inputArray['district'],
				'constituency' => $inputArray['constituency'],
				'village' => $inputArray['village'],

				'passport' => $inputArray['passport'],
				'nin' => $inputArray['nin'],
				'lvc' => $inputArray['lvc'],
				'role_c' => $inputArray['role_c'],
				'ninfp' => $inputArray['ninfp'],
				'ninfn' => $inputArray['ninfn'],
				'ppfp' => $inputArray['ppfp'],
				'ppfn' => $inputArray['ppfn'],
				'user_id' => $inputArray['user_id'],
			];
			$this->WriteFileLog('check');
			$email = $input['nin'];
			$email_check = DB::select("select * from user_general_details where nin = '$email' and active_flag = '1'");
			$this->WriteFileLog('check');
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {



				DB::transaction(function () use ($input) {
					$role_id = DB::table('user_general_details')
						->insertGetId([
							'fname' => $input['fname'],
							'lname' => $input['lname'],
							'gender' => $input['gender'],
							'Address_line1' => $input['Address_line1'],
							'district' => $input['district'],
							'constituency' => $input['constituency'],
							'village' => $input['village'],
							'nin' => $input['nin'],
							'user_id' => $input['user_id'],
							'passport' => $input['passport'],
							'lvc' => $input['lvc'],
							'role_c' => $input['role_c'],
							'ninfp' => $input['ninfp'],
							'ninfn' => $input['ninfn'],
							'ppfp' => $input['ppfp'],
							'ppfn' => $input['ppfn'],
							'active_flag' => 0,
							'created_at' => NOW(),

						]);

					// $this->WriteFileLog($input['screen_id']);



					//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
					//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

					//   $role_name_fetch=$role_name[0]->role_name;
					//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

				});
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function generalupdate(Request $request)
	{
		$this->WriteFileLog('surfh');
		$this->WriteFileLog($request);

		try {
			$method = 'Method => General_registation => storedata';
			$inputArray = $request->requestData;
			$this->WriteFileLog($inputArray);
			// 		  $data['fname'] = $request->fname;
			// 		  $data['lname'] = $request->lname;
			// 		  $data['gender'] = $request->gender;
			// 		  $data['Address_line1'] = $request->Address_line1;
			// 	  $data['consistueny'] = $request->consistueny;
			// 	  $data['providence'] = $request->providence;
			// 	  $data['email'] = $request->email;
			// 	  $data['mobile_no'] = $request->mobile_no;
			// 	  $data['nin'] = $request->nin;
			//   $data['passport'] = $request->passport;
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$input = [
				'fname' => $inputArray['fname'],
				'lname' => $inputArray['lname'],
				'gender' => $inputArray['gender'],
				'Address_line1' => $inputArray['Address_line1'],
				'district' => $inputArray['district'],
				'constituency' => $inputArray['constituency'],
				'village' => $inputArray['village'],

				'passport' => $inputArray['passport'],
				'nin' => $inputArray['nin'],
				'lvc' => $inputArray['lvc'],
				'role_c' => $inputArray['role_c'],
				'ninfp' => $inputArray['ninfp'],
				'ninfn' => $inputArray['ninfn'],
				'ppfp' => $inputArray['ppfp'],
				'ppfn' => $inputArray['ppfn'],
				'user_id' => $inputArray['user_id'],
			];
			$this->WriteFileLog('check');
			$email = $input['nin'];
			$email_check = DB::select("select * from user_general_details where nin = '$email' and active_flag = '1'");
			$this->WriteFileLog('check');
			$this->WriteFileLog(json_encode($email_check));
			if (true) {
				DB::transaction(function () use ($input) {
					$update_id =  DB::table('user_general_details')
						->where([['user_id',  $input['user_id'],]])
						->update([
							'fname' => $input['fname'],
							'lname' => $input['lname'],
							'gender' => $input['gender'],
							'Address_line1' => $input['Address_line1'],
							'district' => $input['district'],
							'constituency' => $input['constituency'],
							'village' => $input['village'],
							'nin' => $input['nin'],
							'user_id' => $input['user_id'],
							'passport' => $input['passport'],
							'lvc' => $input['lvc'],
							'role_c' => $input['role_c'],
							'ninfp' => $input['ninfp'],
							'ninfn' => $input['ninfn'],
							'ppfp' => $input['ppfp'],
							'ppfn' => $input['ppfn'],
							'active_flag' => 0,
							'updated_at' => NOW(),
						]);



					// $this->WriteFileLog($input['screen_id']);



					//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
					//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

					//   $role_name_fetch=$role_name[0]->role_name;
					//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

				});
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function storedynamic(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$this->WriteFileLog($inputArray);

			$count = array();
			$count = array();
			if ($inputArray['ug'] !== null) {

				$count['ug'] = count($inputArray['ug']);
			} else {
				$count['ug'] = "0";
			}
			$this->WriteFileLog("1");
			if ($inputArray['pg'] !== null) {
				$count['pg'] = count($inputArray['pg']);
			} else {
				$count['pg'] = "0";
			}
			$this->WriteFileLog("2");
			if ($inputArray['dip'] !== null) {
				$count['dip'] = count($inputArray['dip']);
			} else {
				$count['dip'] = "0";
			}
			$this->WriteFileLog("3");
			$count['user_id'] = $inputArray['user_id'];
			$email_check = DB::select("select * from user_education_details where user_id = '$userID' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uedid = DB::table('user_education_details')
					->insertGetId([
						'ugc' => $count['ug'],
						'pgc' => $count['pg'],
						'dipc' => $count['dip'],
						'status' => 'New',
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);
				$inputArray['ug'][0]['uedid'] = $uedid;
				$inputArray['pg'][0]['uedid'] = $uedid;
				$inputArray['dip'][0]['uedid'] = $uedid;
				$input = [
					'ug' => $inputArray['ug'],
					'pg' => $inputArray['pg'],
					'dip' => $inputArray['dip'],

				];
				$this->WriteFileLog('z');
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$uedid =  $data[0]['uedid'];


							$this->WriteFileLog($uedid);


							$this->WriteFileLog('y');

							$role_id = DB::table($data[$i]['table'])
								->insertGetId([

									'graduation' => $data[$i]['graduation'],
									'college_name' => $data[$i]['college_name'],
									'university_name' => $data[$i]['university_name'],
									'course_name' => $data[$i]['course_name'],
									'yop' => $data[$i]['yop'],
									'm_percentage' => $data[$i]['m_percentage'],
									'cfp' => $data[$i]['cfp'],
									'cfn' => $data[$i]['cfn'],
									'gfp' => $data[$i]['gfp'],
									'gfn' => $data[$i]['gfn'],
									'user_id' => $data[$i]['user_id'],
									'uedid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);
						}

						// $this->WriteFileLog($input['screen_id']);



						//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
						//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

						//   $role_name_fetch=$role_name[0]->role_name;
						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function updatedynamic(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();

			if ($inputArray['ug'] !== null) {

				$count['ug'] = count($inputArray['ug']);
			} else {
				$count['ug'] = "0";
			}
			$this->WriteFileLog("1");
			if ($inputArray['pg'] !== null) {
				$count['pg'] = count($inputArray['pg']);
			} else {
				$count['pg'] = "0";
			}
			$this->WriteFileLog("2");
			if ($inputArray['dip'] !== null) {
				$count['dip'] = count($inputArray['dip']);
			} else {
				$count['dip'] = "0";
			}
			$count['user_id'] = $inputArray['user_id'];

			$input1 = array();
			$input1['gen'][0]['table']  = 'user_education_details';
			$input1['ug'][0]['table']  = 'user_education_ug_details';
			$input1['pg'][0]['table']  = 'user_education_pg_details';
			$input1['dip'][0]['table'] = 'user_education_dip_details';
			$input1['gen'][0]['user_id']  = $inputArray['user_id'];
			$input1['ug'][0]['user_id']  = $inputArray['user_id'];
			$input1['pg'][0]['user_id']  = $inputArray['user_id'];
			$input1['dip'][0]['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($input1);
			foreach ($input1 as $data) {
				DB::transaction(function () use ($data) {
					$count = count($data);
					for ($i = 0; $i < $count; $i++) {
						$this->WriteFileLog('de');

						$this->WriteFileLog('el');

						$role_id = DB::table($data[$i]['table'])
							->where('user_id', $data[$i]['user_id'])
							->delete();
					}
				});
			}


			$this->WriteFileLog('qw');

			$email_check = DB::select("select * from user_education_details where user_id = '$userID' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$this->WriteFileLog('df');
				$uedid = DB::table('user_education_details')
					->insertGetId([
						'ugc' => $count['ug'],
						'pgc' => $count['pg'],
						'dipc' => $count['dip'],
						'status' => 'New',
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);


				if ($inputArray['ug'] !== null) {

					$inputArray['ug'][0]['uedid'] = $uedid;
				}

				$this->WriteFileLog("1");
				if ($inputArray['pg'] !== null) {
					$inputArray['pg'][0]['uedid'] = $uedid;
				}

				$this->WriteFileLog("2");
				if ($inputArray['dip'] !== null) {
					$inputArray['dip'][0]['uedid'] = $uedid;
				}

				$input = [
					'ug' => $inputArray['ug'],
					'pg' => $inputArray['pg'],
					'dip' => $inputArray['dip'],

				];
				$this->WriteFileLog('z');
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$this->WriteFileLog($data);
						if ($data != null) {
							$this->WriteFileLog('qwser');
							$count = count($data);
						} else {
							$this->WriteFileLog('qwer');
							$count = "0";
						}

						$this->WriteFileLog($count);
						$this->WriteFileLog($data);

						for ($i = 0; $i < $count; $i++) {
							$uedid =  $data[0]['uedid'];

							if ($data[$i]['graduation'] == U_UNDEFINED_VARIABLE) {
								$this->WriteFileLog('oppp');
							}
							$this->WriteFileLog($uedid);
							$this->WriteFileLog('y');

							$this->WriteFileLog($i);

							$this->WriteFileLog('y');

							$role_id = DB::table($data[$i]['table'])
								->insertGetId([

									'graduation' => $data[$i]['graduation'],
									'college_name' => $data[$i]['college_name'],
									'university_name' => $data[$i]['university_name'],
									'course_name' => $data[$i]['course_name'],
									'yop' => $data[$i]['yop'],
									'm_percentage' => $data[$i]['m_percentage'],
									'cfp' => $data[$i]['cfp'],
									'cfn' => $data[$i]['cfn'],
									'gfp' => $data[$i]['gfp'],
									'gfn' => $data[$i]['gfn'],
									'user_id' => $data[$i]['user_id'],
									'uedid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);
						}

						// $this->WriteFileLog($input['screen_id']);



						//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
						//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

						//   $role_name_fetch=$role_name[0]->role_name;
						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function storedynamic1(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();
			$count['cert'] = count($inputArray['cert']);
			$count['expc'] = count($inputArray['wre']);
			$count['we'] = $inputArray['exp']['we'];
			$count['wrqch'] = $inputArray['exp']['wrqch'];
			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_exp_details where user_id = '$userID' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uedid = DB::table('user_exp_details')
					->insertGetId([
						'experience' => $count['we'],
						'wrqch' => $count['wrqch'],
						'certc' => $count['cert'],
						'expc' => $count['expc'],
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);
				$inputArray['cert'][0]['uedid'] = $uedid;
				$inputArray['wre'][0]['uedid'] = $uedid;
				$inputArray['wrq']['uedid'] = $uedid;
				$input1 = [
					'wrq' => $inputArray['wrq'],
				];
				$input2 = [
					'wre' => $inputArray['wre'],
				];
				$input3 = [
					'cert' => $inputArray['cert'],
				];
				$this->WriteFileLog($count['wrqch']);
				if ($count['wrqch'] == "yes") {


					foreach ($input1 as $data) {
						DB::transaction(function () use ($data) {
							$count = count($data);

							$this->WriteFileLog('y');
							$uedid =  $data['uedid'];
							$this->WriteFileLog($uedid);
							$this->WriteFileLog('y');

							$role_id = DB::table($data['table'])
								->insertGetId([

									'cpvw' => $data['cpvw'],
									'teic' => $data['teic'],
									'acrr' => $data['acrr'],
									'imc' => $data['imc'],
									'laal' => $data['laal'],

									'user_id' => $data['user_id'],
									'uexid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);



							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				} elseif ($count['wrqch'] == "no") {


					foreach ($input2 as $data) {
						DB::transaction(function () use ($data) {
							$count = count($data);
							for ($i = 0; $i < $count; $i++) {
								$this->WriteFileLog('y');
								$uedid =  $data[0]['uedid'];
								$this->WriteFileLog($uedid);
								$this->WriteFileLog('y');

								$role_id = DB::table($data[$i]['table'])
									->insertGetId([

										'fde' => $data[$i]['fde'],
										'tde' => $data[$i]['tde'],
										'aow' => $data[$i]['aow'],
										'ep' => $data[$i]['ep'],
										'des' => $data[$i]['des'],
										'rel' => $data[$i]['rel'],

										'user_id' => $data[$i]['user_id'],
										'uexid' => $uedid,
										'active_flag' => 0,
										'created_at' => NOW(),
									]);
							}
							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				}
				$this->WriteFileLog('z');

				foreach ($input3 as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$uedid =  $data[0]['uedid'];
							$this->WriteFileLog($uedid);
							$this->WriteFileLog('y');

							$role_id = DB::table($data[$i]['table'])
								->insertGetId([

									'nopb' => $data[$i]['nopb'],
									'certib' => $data[$i]['ib'],
									'certfp' => $data[$i]['certfp'],
									'certfn' => $data[$i]['certfn'],
									'user_id' => $data[$i]['user_id'],
									'uexid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function updatedynamic1(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();

			$count['cert'] = count($inputArray['cert']);
			$count['expc'] = count($inputArray['wre']);
			$count['we'] = $inputArray['exp']['we'];
			$count['wrqch'] = $inputArray['exp']['wrqch'];
			$count['user_id'] = $inputArray['user_id'];
			if ($inputArray['cert'] !== null) {

				$count['cert'] = count($inputArray['cert']);
			} else {
				$count['cert'] = "0";
			}
			$this->WriteFileLog("1");
			if ($inputArray['wre'] !== null) {
				$count['expc'] = count($inputArray['wre']);
			} else {
				$count['expc'] = "0";
			}
			$this->WriteFileLog("2");

			$count['user_id'] = $inputArray['user_id'];

			$input1 = array();
			$input1['exp'][0]['table']  = 'user_exp_details';
			$input1['wre'][0]['table']  = 'user_exp_wre_details';
			$input1['wrq'][0]['table']  = 'user_exp_wrq_details';
			$input1['cert'][0]['table'] = 'user_exp_cert_details';
			$input1['exp'][0]['user_id']  = $inputArray['user_id'];
			$input1['wre'][0]['user_id']  = $inputArray['user_id'];
			$input1['wrq'][0]['user_id']  = $inputArray['user_id'];
			$input1['cert'][0]['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($input1);
			foreach ($input1 as $data) {
				DB::transaction(function () use ($data) {
					$count = count($data);
					for ($i = 0; $i < $count; $i++) {
						$this->WriteFileLog('de');

						$this->WriteFileLog('el');

						$role_id = DB::table($data[$i]['table'])
							->where('user_id', $data[$i]['user_id'])
							->delete();
					}
				});
			}

			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_exp_details where user_id = '$userID' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uedid = DB::table('user_exp_details')
					->insertGetId([
						'experience' => $count['we'],
						'wrqch' => $count['wrqch'],
						'certc' => $count['cert'],
						'expc' => $count['expc'],
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);
				$inputArray['cert'][0]['uedid'] = $uedid;
				$inputArray['wre'][0]['uedid'] = $uedid;
				$inputArray['wrq']['uedid'] = $uedid;
				$input1 = [
					'wrq' => $inputArray['wrq'],
				];
				$input2 = [
					'wre' => $inputArray['wre'],
				];
				$input3 = [
					'cert' => $inputArray['cert'],
				];
				$this->WriteFileLog($count['wrqch']);
				if ($count['wrqch'] == "yes") {


					foreach ($input1 as $data) {
						DB::transaction(function () use ($data) {
							$count = count($data);

							$this->WriteFileLog('y');
							$uedid =  $data['uedid'];
							$this->WriteFileLog($uedid);
							$this->WriteFileLog('y');

							$role_id = DB::table($data['table'])
								->insertGetId([

									'cpvw' => $data['cpvw'],
									'teic' => $data['teic'],
									'acrr' => $data['acrr'],
									'imc' => $data['imc'],
									'laal' => $data['laal'],

									'user_id' => $data['user_id'],
									'uexid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);



							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				} elseif ($count['wrqch'] == "no") {


					foreach ($input2 as $data) {
						DB::transaction(function () use ($data) {
							$count = count($data);
							for ($i = 0; $i < $count; $i++) {
								$this->WriteFileLog('y');
								$uedid =  $data[0]['uedid'];
								$this->WriteFileLog($uedid);
								$this->WriteFileLog('y');

								$role_id = DB::table($data[$i]['table'])
									->insertGetId([

										'fde' => $data[$i]['fde'],
										'tde' => $data[$i]['tde'],
										'aow' => $data[$i]['aow'],
										'ep' => $data[$i]['ep'],
										'des' => $data[$i]['des'],
										'rel' => $data[$i]['rel'],

										'user_id' => $data[$i]['user_id'],
										'uexid' => $uedid,
										'active_flag' => 0,
										'created_at' => NOW(),
									]);
							}
							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				}
				$this->WriteFileLog('z');

				foreach ($input3 as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$uedid =  $data[0]['uedid'];
							$this->WriteFileLog($uedid);
							$this->WriteFileLog('y');

							$role_id = DB::table($data[$i]['table'])
								->insertGetId([

									'nopb' => $data[$i]['nopb'],
									'certib' => $data[$i]['ib'],
									'certfp' => $data[$i]['certfp'],
									'certfn' => $data[$i]['certfn'],
									'user_id' => $data[$i]['user_id'],
									'uexid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function storeeqans(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();
			$count['q'] = count($inputArray['q']);
			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag = 0");
			$this->WriteFileLog(json_encode($email_check));
			$this->WriteFileLog('bhh');
			if (json_encode($email_check) == '[]') {
				$this->WriteFileLog('bha');
				$uelid = DB::table('user_eligible_details')
					->insertGetId([
						'qc' => $count['q'],
						'status' => 'New',
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);

				$inputArray['q'][0]['uelid'] = $uelid;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						$this->WriteFileLog($count);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$uelid =  $data[0]['uelid'];
							$this->WriteFileLog('y');

							$role_id = DB::table($data[$i]['table'])
								->insertGetId([


									'qid' => $data[$i]['qid'],
									'qans' => $data[$i]['qans'],
									'uelid' => $uelid,
									'user_id' => $data[$i]['user_id'],
									'active_flag' => 0,
									'created_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function updateeqans(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();
			$count['q'] = count($inputArray['q']);
			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_eligible_details')
					->where(['user_id', $count['user_id']])
					->update([
						'qc' => $count['q'],
						'status' => 'New',
						'user_id' => $count['user_id'],

						'created_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						$this->WriteFileLog($count);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$user_id =  $data[0]['user_id'];
							$this->WriteFileLog('y');
							$update_id =  DB::table($data[$i]['table'])
								->where([['user_id', $user_id], ['qid', $data[$i]['qid']]])
								->update([
									'qans' => $data[$i]['qans'],
									'updated_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function deleteeqans(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_eligible_details')
					->where(['user_id', $count['user_id']])
					->update([
						'active_flag' => '0',
						'updated_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						$this->WriteFileLog($count);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$user_id =  $data[0]['user_id'];
							$this->WriteFileLog('y');
							$update_id =  DB::table($data[$i]['table'])
								->where([['user_id', $user_id]])
								->update([
									'active_flag' => "1",
									'updated_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function deletegen(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_general_details')
					->where(['user_id', $count['user_id']])
					->update([
						'active_flag' => '0',
						'updated_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);

				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function deleteexp(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_education_details')
					->where(['user_id', $count['user_id']])
					->update([
						'active_flag' => '0',
						'updated_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						$this->WriteFileLog($count);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$user_id =  $data[0]['user_id'];
							$this->WriteFileLog('y');
							$update_id =  DB::table($data[$i]['table'])
								->where([['user_id', $user_id]])
								->update([
									'active_flag' => "1",
									'updated_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function deleteedu(Request $request)
	{
		$this->WriteFileLog('surfh');

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$this->WriteFileLog($count['user_id']);
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			$this->WriteFileLog(json_encode($email_check));
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_education_details')
					->where(['user_id', $count['user_id']])
					->update([
						'active_flag' => '0',
						'updated_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				$this->WriteFileLog($input);
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						$this->WriteFileLog($count);
						for ($i = 0; $i < $count; $i++) {
							$this->WriteFileLog('y');
							$user_id =  $data[0]['user_id'];
							$this->WriteFileLog('y');
							$update_id =  DB::table($data[$i]['table'])
								->where([['user_id', $user_id]])
								->update([
									'active_flag' => "1",
									'updated_at' => NOW(),
								]);
						}

						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$this->WriteFileLog('c');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$this->WriteFileLog('a');
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
		} catch (\Exception $exc) {
			$this->WriteFileLog('b');
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
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
			'user_type' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 401);
		}
		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		$success['token'] =  $user->createToken('MyApp')->accessToken;
		$success['name'] =  $user->name;
		return response()->json(['success' => $success]);
	}

	public function User()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$userID = auth()->user()->id;
			// $this->WriteFileLog('sara');
			$rows = DB::table('users')
				->select('id', 'name', 'email', 'user_type')
				->where('id', $userID)
				->get();
			// 
			$multipleDevice = 0;
			$get_data = DB::select("SELECT audit_id , login_time , audit_id , login_token FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 2");
			$last_token = $get_data[0]->login_token;
			if (isset($get_data[1])) {
				$last_token1 = $get_data[1]->login_token;
				$decrytoken1 = $this->DecryptData($last_token1);
				if (isset($decrytoken1['token'])) {
					$last_accessKey1 = $decrytoken1['token'];
				} else {
					$last_accessKey1 = '';
				}
			} else {
				$last_accessKey1 = '';
			}

			$decrytoken = $this->DecryptData($last_token);
			$formattedDateTime = $decrytoken['formattedDateTime'];
			if (isset($decrytoken['token'])) {
				$last_accessKey = $decrytoken['token'];
				$activeCheck = $decrytoken['activeCheck'];
			} else {
				$last_accessKey = '';
				$activeCheck = '';
			}
			$currentDateTime = Date::now()->setTimezone('Asia/Kolkata');
			if ($last_accessKey1 != $last_accessKey) {
				if ($activeCheck == 1) {
					$multipleDevice = 1;
				}
			}
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $rows;
			$serviceResponse['formattedDateTime'] = $formattedDateTime;
			$serviceResponse['multipleDevice'] = $multipleDevice;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
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

	public function get_user_list()
	{
		$logMethod = 'Method => UserController => get_user_list';

		try {

			$rows = DB::select('select ur.role_name , a.name,a.id,a.email,c.designation_name,a.active_flag from users as a 
			inner join designation as c on c.designation_id =  a.designation_id 
			INNER JOIN uam_roles AS ur ON ur.role_id = a.array_roles where a.delete_status = 0 ORDER BY a.id DESC ');

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





	public function department_list()
	{
		$logMethod = 'Method => UserController => department_list';
		try {
			$parent_department = config('setting.parent_department');
			$rows = DB::select("SELECT * FROM document_folder_structures WHERE parent_document_folder_structure_id Not IN  ($parent_department) AND active_flag =1 ");

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



	public function project_roles_list()
	{
		$logMethod = 'Method => UserController => project_roles_list';
		try {

			$rows = DB::select('select * from project_roles where active_flag = 1');

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





	public function get_roles_list()
	{
		$logMethod = 'Method => UserController => get_roles_list';

		try {

			$rows = DB::table('uam_roles')
				->select('*')
				->where('active_flag', 0)
				->get();

			$project_roles = DB::table('project_roles')
				->select('*')
				->where('active_flag', 1)
				->get();



			// $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");   
			// $document_folder_structure_id = $document[0]->document_folder_structure_id;

			// $parent_folder = DB::select("select a.document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
			// 	from document_folder_structures as a where a.parent_document_folder_structure_id = 0");

			// $directorate = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('document_folder_structure_id',2)
			// ->get();

			// $department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();


			// $sub_department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();

			$designation = DB::table('designation')
				->select('*')
				->where('active_flag', 0)
				->get();

			$dashboard = DB::table('user_dashboard_list')
				->select('*')
				->where('default_status', 0)
				->get();

			// $document_category = DB::select("select * from document_categories where active_flag = 1");

			$response = [
				'rows' => $rows,
				// 'directorate' => $directorate,
				'designation' => $designation,
				// 'document_folder_structure_id' => $document_folder_structure_id,
				'dashboard' => $dashboard,
				// 'parent_folder' => $parent_folder,
				// 'department' => $department,
				// 'sub_department' => $sub_department,
				// 'document_category' => $document_category,
				'project_roles' => $project_roles,
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



	public function get_department_list(Request $request)
	{
		$logMethod = 'Method => UserController => get_department_list';
		try {
			$input = $this->decryptData($request->requestData);
			$directorate_id  = $input['directorate'];
			// $directorate_id =implode(",",$directorate);
			// echo "select * from document_folder_structures where parent_document_folder_structure_id  IN ($directorate_id)";
			// exit;
			// echo json_encode($directorate_id);exit;
			$department = DB::select("select * from document_folder_structures where parent_document_folder_structure_id='$directorate_id'");
			//echo json_encode($department);exit;
			$response = [
				'department' => $department,
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

	// public function google_account(Googl $googl)
	// {
	// 	$this->client = $googl->getclient();
	// 	$this->client->setAuthConfig(storage_path('calendar.json'));
	// }
	public function user_register(Request $request, Googl $googl)
	{
		$logMethod = 'Method => UserController => user_register';
		// $this->WriteFileLog($logMethod);
		try {
			$input = $this->decryptData($request->requestData);
			$name  = $input['name'];
			$wsemailname  = strtolower($name);
			$wsemailname  = $wsemailname . rand(0, 1000);

			$email =  $input['email'];
			$rowsemail =  DB::select("select * from users where email ='$email'");
			// $this->WriteFileLog($rowsemail);

			if (json_encode($rowsemail) != '[]') {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {

				$roles_id =  $input['roles_id'];
				// $this->WriteFileLog($roles_id);

				$user_password = $input['password'];
				// $this->WriteFileLog($user_password);

				$role_name = DB::select("select role_name from uam_roles where role_id ='$roles_id'");
				// $this->WriteFileLog($role_name);
				// if($role_name[0]->role_name == "IS Head"){
				// 	try {
				// 		$client = $googl->getclient();

				// 		$service = new \Google_Service_Directory($client);
				// 		$nameInstance = new \Google_Service_Directory_UserName();
				// 		$nameInstance->setGivenName('Elina');
				// 		$nameInstance->setFamilyName('Service');
				// 		$emailws = $wsemailname.'@1daymaidservices.com';
				// 		$password = $user_password;
				// 		$userInstance = new \Google_Service_Directory_User();
				// 		$userInstance->setName($nameInstance);
				// 		$userInstance->setHashFunction("MD5");
				// 		$userInstance->setPrimaryEmail($emailws);
				// 		$userInstance->setPassword(hash("md5", $password));
				// 		$createUserResult = $service->users->insert($userInstance);
				// 		$createUserResult = json_decode( json_encode($createUserResult), true);
				// 		$input['emailws'] = $createUserResult->primaryEmail;
				// 	}
				// 	catch(\Exception $exc){
				// 		$serviceResponse = array();
				// 		$serviceResponse['Code'] = 400;
				// 		$serviceResponse['Message'] = config('setting.status_message.success');
				// 		$serviceResponse['Data'] = 1;
				// 		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				// 		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				// 		return $sendServiceResponse;
				// 	}
				// }

				$user_inser_id = DB::transaction(function () use ($input) {
					$user_password = $input['password'];
					$dashboard_list_id = $input['dashboard_list_id'];
					$stringdashboard_list_id = implode(",", $dashboard_list_id);
					// $directorate = $input['directorate'];
					$input['password'] = bcrypt($input['password']);
					$user_id = DB::table('users')
						->insertGetId([
							'name' => $input['name'],
							'email' => $input['email'],
							// 'workspace_email' => $input['emailws'],
							'user_type' => $input['user_type'],
							'password' => $input['password'],
							'array_dashboard_list' => $stringdashboard_list_id,
							'designation_id' => $input['designation'],
							'profile_image' => '/images/profile-picture.webp',
							'profile_image' => '/user_signature/67/am9obm55LWRlcHAuanBn.jpg',
							'roles' => ($input['additional_roles_id'] !== null ? implode(',', $input['additional_roles_id']) : null),
						]);

					$user_id  =  $user_id;
					$designation = $input['designation'];

					$screenidcount = count($input['dashboard_list_id']);
					for ($i = 0; $i < $screenidcount; $i++) {
						$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
							'user_id' => $user_id,
							'user_dashboard_list_id' => $input['dashboard_list_id'][$i],
							'active_flag' => 0,
							'created_by' => $user_id,
						]);
					};



					$roles_data_id = $input['roles_id'];
					$stringuser_id = $input['roles_id'];
					$update_id =  DB::table('users')
						->where('id', $user_id)
						->update([
							'array_roles' => $stringuser_id,
						]);

					//KD
					$role_change_id = DB::table('userrole_audit')
						->insertGetId([
							'current_role_id' => $stringuser_id,
							'user_id' => $user_id,
							'created_by' => auth()->user()->id,
							'audit_status' => "Newly Added"
						]);

					//KD
					$data = [
						'name' => $input['name'],
						'email' => $input['email'],
						'password' => $user_password,
					];
					Mail::to($input['email'])->send(new SendUserCreateMail($data));

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_type' => 'create a user',
						'notification_status' => 'User Created',
						'notification_url' => 'user',
						'megcontent' => "User " . $input['name'] . " created Successfully and mail sent.",
						'alert_meg' => "User " . $input['name'] . " created Successfully and mail sent.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);



					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $input['roles_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);


					$role_id = $input['roles_id'];
					$additional_roles = $input['additional_roles_id'];
					$rolesArray = ($additional_roles !== null ? implode(',', array_merge([$role_id], $additional_roles)) : $role_id);
					$parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id in ($rolesArray)");
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							} else {
							}
						};
					};



					$checking = DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");
					$checkcounting = count($checking);
					if ($checking != []) {
						for ($k = 0; $k < $checkcounting; $k++) {
							$screen_id = $checking[$k]->screen_id;
							$user_screen_id = $checking[$k]->user_screen_id;

							$permissioncheck = DB::select("select DISTINCT b.array_permission, a.* from uam_screen_permissions as a
								inner join uam_role_screen_permissions as b on b.screen_permission_id = a.screen_permission_id
								where a.screen_id  = '$screen_id' and b.role_id in ($rolesArray)");

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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};





					// $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
					// 	INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

					// $role_name_fetch=$role_name[0]->role_name;
					$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', $user_id, NOW(), '');

					return $user_id;
				});




				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $user_inser_id;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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

	public function data_edit($id)
	{
		$method = 'Method => UserController => data_edit';
		/// echo json_encode($id);exit;
		try {
			$id = $this->decryptData($id);


			// $one_row = DB::select("select a.*,b.*,c.array_department as array_category from users as a inner join user_departments as b on b.user_id = a.id inner join users_document_categories as c on c.user_id = a.id where a.id = $id ");
			$one_row = DB::select("select * from users where id = $id ");
			$rows_data = DB::table('uam_roles')

				->select('*')
				->where('active_flag', 0)
				->get();
			// $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");   
			// $document_folder_structure_id = $document[0]->document_folder_structure_id;

			// $parent_folder = DB::select("select a.document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
			// 	from document_folder_structures as a where a.parent_document_folder_structure_id = 0");

			// $directorate = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('document_folder_structure_id',2)
			// ->get();

			// $department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();

			// $sub_department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();


			$designation = DB::table('designation')
				->select('*')
				->where('active_flag', 0)
				->get();

			$dashboard = DB::table('user_dashboard_list')
				->select('*')
				->where('default_status', 0)
				->get();

			// $document_category = DB::select("select * from document_categories where active_flag = 1");
			$project_roles = DB::table('project_roles')
				->select('*')
				->where('active_flag', 1)
				->get();

			$response = [
				'one_row' => $one_row,
				'rows_data' => $rows_data,
				// 'parent_folder' => $parent_folder,
				// 'directorate' => $directorate,
				// 'department' => $department, 
				// 'sub_department' => $sub_department,
				'designation' => $designation,
				// 'document_folder_structure_id' => $document_folder_structure_id,
				'dashboard' => $dashboard,
				// 'document_category' => $document_category,
				'project_roles' => $project_roles
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
		$method = 'Method => UserController => updatedata';
		// $this->WriteFileLog($request);
		try {
			$input = $this->decryptData($request->requestData);
			$id  = $input['user_id'];
			$email =  $input['email'];
			$rowsemail =  DB::select("select * from users where not id  = '$id' and email ='$email'");
			if (json_encode($rowsemail) != '[]') {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				DB::transaction(function () use ($input) {
					$user_id  = $input['user_id'];
					$roles_data_id = $input['roles_id'];
					$stringuser_id = $input['roles_id'];

					$dashboard_list_id = $input['dashboard_list_id'];
					if ($dashboard_list_id != []) {
						$stringdashboard_list_id = implode(",", $dashboard_list_id);
					} else {
						$stringdashboard_list_id = '';
					}


					// $directorate = $input['directorate'];


					//KD

					$find_user = DB::select("SELECT * from users where id=" . $user_id . "");
					$previous_role = $find_user[0]->array_roles;


					if ($previous_role != $stringuser_id) {


						$get_data = DB::select("SELECT  current_role_id FROM userrole_audit WHERE user_id=" . $user_id . " ORDER BY action_date DESC LIMIT 1");



						$previous_id = $get_data[0]->current_role_id;

						$role_change_id = DB::table('userrole_audit')
							->insertGetId([


								'current_role_id' => $stringuser_id,
								'previous_role_id' => $previous_id,
								'user_id' => $user_id,
								'created_by' => auth()->user()->id,
								'audit_status' => "Updated"



							]);
					}
					//KD
					$updated_mail =  DB::select("SELECT email,name from users where id=$user_id");
					$db_mail = $updated_mail[0]->email;
					$db_name = $updated_mail[0]->name;
					$email =  $input['email'];
					$data = array(
						'child_name' => $db_name,
						'email' => $email,
					);
					// $this->WriteFileLog($data);
					// $this->WriteFileLog($db_mail);
					// $this->WriteFileLog($email);
					if ($db_mail != $email) {
						$mail = $input['email'];
						Mail::to($mail)->send(new userupdateemail($data));
						// $this->WriteFileLog($mail);
					}

					DB::table('users')
						->where('id', $user_id)
						->update([
							'array_roles' => $stringuser_id,
							'name' => $input['name'],
							'email' => $input['email'],
							'array_dashboard_list' => $stringdashboard_list_id,
							'designation_id' => $input['designation'],
							'project_role_id' => $input['project_role_id'],
							'roles' => ($input['additional_roles_id'] !== null ? implode(',', $input['additional_roles_id']) : null),
						]);

					DB::table('enrollment_details')
						->where('user_id', $user_id)
						->update([
							'child_contact_email' => $input['email'],
						]);



					// $delete_user_department_id  = DB::table('user_departments')->where('user_id', $user_id)->delete();


					$designation = $input['designation'];
					// $screen_unique = array_unique($input['directorate_department']);
					// $unique = array_values($screen_unique);
					// $screenidcount = count($unique);


					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);


					// for ($i=0; $i < $screenidcount; $i++) { 
					// 	$iparr = explode(":", $unique[$i]); 
					// 	$user_departments_id = DB::table('user_departments')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'parent_node_id' => $input['parent_node_id'],
					// 		'directorate_id' => $iparr[0],
					// 		'department_id' => $iparr[1],
					// 		'designation_id' => $designation,
					// 		//'array_department' => $unique_array_department[$i]
					// 	]);
					// };
					// $delete_user_categories  = DB::table('users_document_categories')->where('user_id', $user_id)->delete();



					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);

					// for ($i=0; $i < $screenunique_array_department; $i++) { 
					// 	$iparr = explode("-", $unique_array_department[$i]); 
					// 	$user_departments_id = DB::table('users_document_categories')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'document_category_id' => $iparr[3],
					// 		'directorate_id' => $iparr[1],
					// 		'department_id' => $iparr[2],
					// 		'array_department' => $unique_array_department[$i]
					// 	]);
					// };



					// $delete_dashboard_list_id  = DB::table('user_selected_dashboard_list')->where('user_id', $user_id)->delete();

					// $screenidcount = count($input['dashboard_list_id']);
					// for ($i=0; $i < $screenidcount; $i++) { 
					// 	$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'user_dashboard_list_id' => $input['dashboard_list_id'][$i],                                        
					// 		'active_flag' => 0,
					// 		'created_by' => $user_id,
					// 	]);
					// };



					$user_screen_id1 = DB::select("select * from uam_user_screens where user_id = '$user_id'");
					$screenidcount1 = count($user_screen_id1);
					for ($w = 0; $w < $screenidcount1; $w++) {
						$uam_user_screen_permissions_id  =  $user_screen_id1[$w]->user_screen_id;
						$delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
					}
					$uam_modules_id =  DB::table('uam_user_roles')
						->where('user_id', $user_id)
						->delete();
					$uam_user_screens =  DB::table('uam_user_screens')
						->where('user_id', $user_id)
						->delete();

					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $input['roles_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);

					$role_id = $input['roles_id'];
					$additional_roles = $input['additional_roles_id'];
					$rolesArray = ($additional_roles !== null ? implode(',', array_merge([$role_id], $additional_roles)) : $role_id);					// $this->WriteFileLog('$rolesArray'); $this->WriteFileLog($rolesArray);
					$parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id in ($rolesArray)");
					$parentidcounting = count($parentrow);
					// $this->WriteFileLog('$parentidcounting'); $this->WriteFileLog($parentidcounting);
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
							// $this->WriteFileLog('$checkcount'); $this->WriteFileLog($checkcount);
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							} else {
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
								where a.screen_id  = '$screen_id' and b.role_id in ($rolesArray)");

							$permissioncheckcount = count($permissioncheck);
							// $this->WriteFileLog('$permissioncheck'); $this->WriteFileLog($permissioncheck);
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};




					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur
					INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', $user_id, NOW(), $role_name);
				});
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
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

	// public function user()
	// {
	//   try {
	//     $rows = DB::table('users')
	//     ->select('name', 'email', 'user_type','id')
	//     ->where('id', auth()->user()->id)
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     
	// }
	// }
	// public function get_user_list()
	// {
	//   try {
	//     $rows = DB::table('users')
	//     ->select('*')
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     
	// }
	// }
	// public function get_roles_list()
	// {
	//   try {
	//     $rows = DB::table('uam_roles')
	//     ->select('*')
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     
	// }
	// }


	public function reset_expire_data_get()
	{

		$method = 'Method => UserController => reset_expire_data_get';
		// $this->WriteFileLog($method );

		try {


			$rows =  DB::select('SELECT * FROM reset_password_token_time_settings');



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


	public function token_expire_data_update(Request $request)
	{

		$method = 'Method => UserController => reset_expire_data_get';

		try {
			$input = $this->decryptData($request->requestData);
			$settings_time = $input['settings_time'];
			$settings_id = $input['settings_id'];
			$settings_movement = $input['settings_movement'];


			if ($settings_movement == 2) {

				$user_inser_id = DB::transaction(function () use ($input) {

					$settings_time = $input['settings_time'];
					$settings_id = $input['settings_id'];
					$settings_movement = $input['settings_movement'];

					DB::table('reset_password_token_time_settings')
						->where('settings_id', $settings_id)
						->update([
							'settings_time' => $settings_time,
							'settings_movement' => $settings_movement,
							'updated_by' => auth()->user()->id,
						]);


					$ew1 = DB::unprepared("DROP EVENT IF EXISTS `et_update_your_trigger_name` ");

					$ew2 =  DB::unprepared("CREATE EVENT `et_update_your_trigger_name`  ON SCHEDULE EVERY $settings_time DAY 

					DO 

					Delete from forget_password_token_list WHERE expire_time < now() - interval $settings_time DAY ");


					$ew3 = DB::unprepared("ALTER EVENT `et_update_your_trigger_name` ON  COMPLETION PRESERVE ENABLE");
				});

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}

			if ($settings_movement == 1) {
				$user_inser_id = DB::transaction(function () use ($input) {

					$settings_time = $input['settings_time'];
					$settings_id = $input['settings_id'];
					$settings_movement = $input['settings_movement'];

					DB::table('reset_password_token_time_settings')
						->where('settings_id', $settings_id)
						->update([
							'settings_time' => $settings_time,
							'settings_movement' => $settings_movement,
							'updated_by' => auth()->user()->id,
						]);


					$ew1 = DB::unprepared("DROP EVENT IF EXISTS `et_update_your_trigger_name` ");

					$ew2 =  DB::unprepared("CREATE EVENT `et_update_your_trigger_name`  ON SCHEDULE EVERY $settings_time HOUR 

					DO 

					Delete from forget_password_token_list WHERE expire_time < now() - interval $settings_time HOUR ");


					$ew3 = DB::unprepared("ALTER EVENT `et_update_your_trigger_name` ON  COMPLETION PRESERVE ENABLE");
				});

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
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




	public function forget_password(Request $request)
	{

		$method = 'Method => UserController => forget_password';
		try {

			//$id = $this->decryptData($id);
			$input = $this->decryptData($request->requestData);
			$this->WriteFileLog($input);
			//  return $input;
			$id = $input['email'];
			$this->WriteFileLog($id);
			$rows =  DB::select("select * from users where email ='$id'");
			$this->WriteFileLog($rows);
			if (json_encode($rows) == '[]') {

				$response_status = 300;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$id1 = $rows[0]->id;
				$email = $rows[0]->email;

				$token = $this->encryptData($email);
				//$token = bin2hex($token);


				$data = [
					'id' => $this->encryptData($id1),
					'name' => $rows[0]->name,
					'email' => $this->encryptData($email),
					'token' => $token,
				];


				Mail::to($rows[0]->email)->send(new SendResetMail($data));
				$response_status = 200;
				$email_encrypt = $this->encryptData($email);
				$response = [
					'response_status' => $response_status
				];
				//KD
				$remember_ps_audit = DB::table('remember_ps_audit')
					->insertGetId([
						'status' => 'Reset Link Sent',
						'user_id' => $id1,
						'url' => '/reset/' . $token,
						'encrypt' => $token

					]);

				$token_send = DB::table('forget_password_token_list')
					->insertGetId([
						'status' => 'Reset Link Sent',
						'user_id' => $id1,
						'url' => '/reset/' . $token,
						'token' => $token

					]);


				// KD

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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







	public function reset($id)
	{

		$method = 'Method => UserController => reset';
		try {

			$rows =  DB::select("select * from forget_password_token_list where token = '$id' ");


			if ($rows == []) {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
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















	public function reset_password(Request $request)
	{
		$method = 'Method => UserController => reset_password';
		try {

			$input = $this->decryptData($request->requestData);


			$password = bcrypt($input['password']);
			$email = $input['email'];

			$pass = $input['password'];


			$user_pass  = DB::select("select * from users where email = '$email' ");

			$user_password =  $user_pass[0]->password;

			if (Hash::check($pass, $user_password)) {


				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {

				$rows =  DB::select("select a.id from users as a  where a.email = '$email' ");
				DB::transaction(function () use ($password, $rows) {
					DB::table('users')
						->where('id', json_encode($rows[0]->id))
						->update([
							'password' => $password,
						]);
				});
				//KD
				$userID = json_encode($rows[0]->id);

				$forget_password_table  = DB::table('forget_password_token_list')->where('user_id', $userID)->delete();

				$get_data = DB::select("SELECT  audit_id FROM remember_ps_audit WHERE user_id=" . $userID . " ORDER BY linksent_time DESC LIMIT 1");

				$last_id = $get_data[0]->audit_id;

				DB::table('remember_ps_audit')

					->where([['user_id', '=', $userID], ['audit_id', '=', $last_id]])
					->update(['status1' => 'Password Reset Successfully', 'active' => 1]);
				// KD

				$response_status = 200;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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



	public function change_password_save(Request $request)
	{
		$method = 'Method => UserController => change_password_save';
		try {
			$input = $this->decryptData($request->requestData);

			$password = bcrypt($input['new_password']);

			$pass = $input['new_password'];

			$user_id = $input['user_id'];



			$user_pass  = DB::select("select * from users where id = '$user_id' ");

			$user_password =  $user_pass[0]->password;

			if (Hash::check($pass, $user_password)) {


				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {


				DB::transaction(function () use ($password, $user_id) {
					DB::table('users')
						->where('id', $user_id)
						->update([
							'password' => $password,
						]);
				});

				$response_status = 200;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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










	public function delete($id)
	{
		//return $id;
		try {

			$method = 'Method => UserController => delete';
			$id = $this->decryptData($id);
			$this->WriteFileLog($method);
			$this->WriteFileLog($id);
			// $document_process_check = DB::select("select * from document_processes where created_by = '$id'");
			// if ($document_process_check != [] ) {
			// 	$serviceResponse = array();
			// 	$serviceResponse['Code'] = 800;
			// 	$serviceResponse['Message'] = config('setting.status_message.success');
			// 	$serviceResponse['Data'] = 1;
			// 	$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			// 	$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			// 	return $sendServiceResponse;

			// }


			// $work_flow_check = DB::select("select * from tasks_common_all_list where created_by = '$id' or allocated_user_id = '$id'");
			// if ($work_flow_check != [] ) {
			// 	$serviceResponse = array();
			// 	$serviceResponse['Code'] = 800;
			// 	$serviceResponse['Message'] = config('setting.status_message.success');
			// 	$serviceResponse['Data'] = 1;
			// 	$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			// 	$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			// 	return $sendServiceResponse;
			// }

			$auth_user_id = auth()->user()->id;


			if ($id  ==  $auth_user_id) {

				$serviceResponse = array();
				$serviceResponse['Code'] = 1000;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}




			// $user_check = DB::select("select * from work_flow_level_user where user_id = '$id'");
			// if ($user_check == []) { 
			$user_check = DB::select("select * from users where id ='$id' AND active_flag=0 AND delete_status = 0");
			if ($user_check != []) {


				DB::transaction(function () use ($id) {
					DB::table('users')
						->where('id', $id)
						->update([
							'active_flag' => 1,
							'delete_status' => 1,
						]);
				});



				// $user_screen_id = DB::select("select * from uam_user_screens where user_id = '$id'");
				// $screenidcount = count($user_screen_id);
				// for ($j=0; $j< $screenidcount; $j++) { 
				// 	$uam_user_screen_permissions_id  =  $user_screen_id[$j]->user_screen_id;
				// 	$delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
				// }
				// DB::transaction(function() use($id){
				// 	$uam_modules_id =  DB::table('uam_user_roles')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });

				// DB::transaction(function() use($id){
				// 	$uam_user_screens =  DB::table('uam_user_screens')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });
				// DB::transaction(function() use($id){
				// 	$user_departments =  DB::table('user_departments')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });
				// DB::transaction(function() use($id){
				// 	$users =  DB::table('users')
				// 	->where('id', $id)
				// 	->delete();                  
				// });


				// $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
				// 	INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

				// $role_name_fetch=$role_name[0]->role_name;

				$this->auditLog('uam_users', $id, 'Delete', 'Deleted the User', auth()->user()->id, NOW(), '');
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
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
	public function edit_permission($id)
	{
		$method = 'Method => UserController => edit_permission';

		try {
			$id = $this->decryptData($id);

			// // Old method with Single Role
			// $modulesrows =  DB::select("select * from uam_user_roles where user_id = $id");
			// $role_id = $modulesrows[0]->role_id;

			$additional = DB::Select("SELECT CASE WHEN roles IS NULL THEN array_roles ELSE CONCAT(array_roles, ',', roles) END AS rolesArray
			FROM users WHERE id = $id");
			$role_id = $additional[0]->rolesArray;

			$role_name_check = DB::select("select role_name from uam_roles where role_id in ($role_id) ");
			$this->WriteFileLog($role_name_check);
			$role_name = $role_name_check[0]->role_name;

			$parent_module_data = DB::table('uam_modules')
				->select('*')
				->where([['parent_module_id', 0], ['active_flag', 0]])
				->get();

			$module_data =  DB::select("select distinct a.module_id,c.module_name,c.parent_module_id from uam_role_screens as a 
			inner join uam_modules as c on c.module_id = a.module_id where a.role_id in ($role_id)");
			// $module_data = DB::table('uam_modules')
			// ->select('*')
			// ->where([['parent_module_id', '!=' , 0],['active_flag',0]])
			// ->get();


			$screen_data = DB::select("select a.module_id,a.screen_id,b.screen_name,a.role_screen_id from uam_role_screens as a 
			inner join uam_screens as b on b.screen_id = a.screen_id where a.role_id in ($role_id) ");

			// $screen_data =  DB::select("select b.screen_id,b.screen_name,c.module_id
			// from uam_module_screens as a inner join uam_screens as b on b.screen_id = a.screen_id inner join uam_modules as c on c.module_id = a.module_id where b.active_flag = 0"); 


			// $permission_data = DB::select("select a.module_id,a.screen_id,a.role_screen_id,b.array_permission,b.screen_permission_id,c.permission from uam_role_screens as a 
			// 	inner join uam_role_screen_permissions as b on b.role_screen_id = a.role_screen_id
			// 	inner join uam_screen_permissions as c on c.screen_permission_id = b.screen_permission_id
			// 	where a.role_id = '$role_id' ");

			$permission_data = DB::table('uam_screen_permissions')
				->select('*')
				->get();

			$this->WriteFileLog('6');

			$rows = DB::select("select array_permission from uam_user_screen_permissions 
			where user_id = $id ");

			$sub_module = DB::select("SELECT * FROM uam_modules AS a 
			WHERE active_flag=0 AND module_type=1 AND parent_module_id!=0");

			$check = DB::select("SELECT GROUP_CONCAT(DISTINCT c.parent_module_id SEPARATOR ' , ') as un from uam_module_screens as a 
			inner join uam_modules as c on c.module_id = a.module_id 
			inner join uam_role_screens as d on d.module_screen_id=a.module_screen_id
			where d.role_id in ($role_id) AND module_type=2");

			$s = $check[0]->un;
			$module_array = explode(",", $s);

			$response = [
				'module_data' => $module_data,
				'screen_data' => $screen_data,
				'permission_data' => $permission_data,
				'user_id' => $id,
				'rows' => $rows,
				'role_name' => $role_name,
				'parent_module_data' => $parent_module_data,
				'sub_module' => $sub_module,
				'module_array' => $module_array
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
	public function updatedatapermission(Request $request)
	{
		try {
			$method = 'Method => UserController => updatedatapermission';
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'user_id' => $inputArray['user_id'],
				'screen_id' => $inputArray['screen_id'],
				'permission_id' => $inputArray['permission_id'],
			];
			$rows1 = DB::table('uam_user_screens')->where('user_id', $input['user_id'])->delete();
			$rows2 = DB::table('uam_user_screen_permissions')->where('user_id', $input['user_id'])->delete();


			DB::transaction(function () use ($input) {
				$screen_unique = array_unique($input['screen_id']);
				$unique = array_values($screen_unique);
				$screenidcount = count($unique);
				for ($i = 0; $i < $screenidcount; $i++) {
					$iparr = explode(":", $unique[$i]);
					$screen_id = $iparr[1];
					$module_id = $iparr[0];
					$screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
					$modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");

					$parent_module_id = $modulesrows[0]->parent_module_id;
					$module_name = $modulesrows[0]->module_name;
					$module_name = $modulesrows[0]->module_name;
					$screen_name = $screenrows[0]->screen_name;
					$screen_url = $screenrows[0]->screen_url;
					$route_url = $screenrows[0]->route_url;
					$class_name = $screenrows[0]->class_name;
					$display_order = $screenrows[0]->display_order;
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
						'user_id' => $input['user_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);
				}
				$permissioncount = count($input['permission_id']);
				for ($j = 0; $j < $permissioncount; $j++) {
					$permission =  $input['permission_id'][$j];
					$permissiondata = substr($permission, 6);
					$iparr = explode("-", $permissiondata);
					$user_id = $input['user_id'];
					$module_id = $iparr[1];
					$screen_id = $iparr[2];
					$permission_id = $iparr[0];
					$this->WriteFileLog($permission_id);
					$rows =  DB::select("select a.user_screen_id from uam_user_screens as a where a.module_id = $module_id and a.user_id = $user_id  and a.screen_id = $screen_id ");
					$permissionrows =  DB::select("select a.permission,a.description,a.active_flag from uam_screen_permissions as a where a.screen_permission_id = $permission_id ");
					$user_screen_id = $rows[0]->user_screen_id;
					$permission_name = $permissionrows[0]->permission;
					$description = $permissionrows[0]->description;
					$active_flag = $permissionrows[0]->active_flag;
					$user_id = $input['user_id'];
					$role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
						'user_screen_id' =>  $user_screen_id,
						'screen_permission_id' =>  $permission_id,
						'permission' => $permission_name,
						'user_id' => $user_id,
						'array_permission' => $permission,
						'description' => $description,
						'active_flag' => $active_flag,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);
				}
				// $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
				// 	INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

				// $role_name_fetch=$role_name[0]->role_name;
				//$this->auditLog('uam_user', $input['user_id'] , 'Update', 'Update uam screen', auth()->user()->id, NOW(),$role_name_fetch);
			});
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
	public function notifications(Request $request)
	{
		$method = 'Method => UserController => notifications';


		try {
			$id = auth()->user()->id;
			$inputArray = $this->decryptData($request->requestData);
			$role = $inputArray['id'];
			
			if ($role == 'parent') {
				$response = [
					'notifications' => DB::select("SELECT * FROM notifications WHERE user_id = $id AND active_flag = 0 ORDER BY notification_id DESC;"),
					'notification_count' => DB::select("SELECT count(*) FROM notifications WHERE user_id = $id AND active_flag = 0;"),
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}

			$count_data = DB::table('notifications as a')->where('a.user_id', $id)->where('a.active_flag', 0)->count();

			$user_data = DB::table('notifications')->where('notification_status', 'User Created')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$user_data_count = DB::table('notifications')->where('notification_status', 'User Created')->where('user_id', $id)->where('active_flag', 0)->count();

			$form_data = DB::table('notifications')->where('notification_status', 'User enrolled')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$form_data_count = DB::table('notifications')->where('notification_status', 'User enrolled')->where('user_id', $id)->where('active_flag', 0)->count();

			$payment_data = DB::table('notifications')->where('notification_type', 'Payment')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$payment_data_count = DB::table('notifications')->where('notification_type', 'Payment')->where('user_id', $id)->where('active_flag', 0)->count();

			$ovmmeeting_data = DB::table('notifications')->where('notification_status', 'OVM Meeting')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$ovmmeeting_data_count = DB::table('notifications')->where('notification_status', 'OVM Meeting')->where('user_id', $id)->where('active_flag', 0)->count();

			$questionnaire_data = DB::table('notifications')->where('notification_type', 'Questionnaire')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$questionnaire_count = DB::table('notifications')->where('notification_type', 'Questionnaire')->where('user_id', $id)->where('active_flag', 0)->count();

			$activity_data = DB::table('notifications')->where('notification_type', 'activity')->where('user_id', $id)->where('active_flag', 0)->orderByDesc('notification_id')->get();
			$activity_count = DB::table('notifications')->where('notification_type', 'activity')->where('user_id', $id)->where('active_flag', 0)->count();

			// $user = DB::select("select * from users where id = $id");

			$response = [
				// 'user' => $user,
				'count_data' => $count_data,
				'user_data' => $user_data,
				'user_data_count' => $user_data_count,
				'form_data' => $form_data,
				'form_data_count' => $form_data_count,
				'payment_data' => $payment_data,
				'payment_data_count' => $payment_data_count,
				'ovmmeeting_data' => $ovmmeeting_data,
				'ovmmeeting_data_count' => $ovmmeeting_data_count,
				'questionnaire_data' => $questionnaire_data,
				'questionnaire_count' => $questionnaire_count,
				'activity_data' => $activity_data,
				'activity_count' => $activity_count
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


	public function notification_alert(Request $request)
	{
		$method = 'Method => UserController => notification_alert';
		try {
			
			$inputArray = $this->decryptData($request->requestData);
			$notification_id =  $inputArray['notification_id'];
			
			DB::transaction(function () use ($notification_id) {
				DB::table('notifications')
					->where('notification_id', $notification_id)
					->update([
						'active_flag' => 1,
					]);
			});
			
			// [Note] Previous process deprecated as of 6 June 2025.
			// Refer to earlier code versions or commits for legacy logic or requirements.
			
			$notification = DB::select("SELECT notification_url from notifications where notification_id =" . $notification_id);

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $notification;
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
	public function profilepage(Request $request)
	{
		$method = 'Method => UserController => profilepage';
		try {
			$id = auth()->user()->id;
			$user = DB::select("select * from users where id = $id");
			$response = [
				'user' => $user
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
	public function profile_update(Request $request)
	{
		$method = 'Method => UserController => profile_update';
		try {
			$input = $this->decryptData($request->requestData);
			$id  = $input['user_id'];
			$phone_number =  $input['phone_number'];
			$signature_attachment =  $input['signature_attachment'];
			$profile_path = $input['profile_path'];
			if ($profile_path != " " && $phone_number != " ") {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'phone_number' =>  $input['phone_number'],
							'profile_image' => $input['signature_attachment'],
							'profile_path' => $input['profile_path']
						]);
				});
			} else if ($profile_path == " " && $phone_number != " ") {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'phone_number' =>  $input['phone_number'],

						]);
				});
			} else {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'profile_image' => $input['signature_attachment'],
							'profile_path' => $input['profile_path']

						]);
				});
			}
			DB::transaction(function () use ($input) {
				DB::table('users')
					->where('id', $input['user_id'])
					->update([
						'email' => $input['email'],
						'name' => $input['name']

					]);
				DB::table('enrollment_details')
					->where('user_id', $input['user_id'])
					->update([
						'child_contact_email' => $input['email'],

					]);
			});
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

	public function update_toggle(Request $request)
	{
		try {

			$method = 'Method => FAQquestionsController => update_toggle';
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'is_active' => $inputArray['is_active'],
				'f_id' => $inputArray['f_id'],

			];


			DB::table('users')

				->where([['id', '=', $input['f_id']]])
				->update(['active_flag' => $input['is_active']]);




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



	public function bulkdummyupload(Request $request)
	{

		try {
			$method = 'Method => DesignationController => bulkdummyupload';
			$inputArray = $this->decryptData($request->requestData);

			$workoutdetails = json_decode($inputArray['jsonObject'], true);

			foreach ($workoutdetails as $key => $value) {

				DB::transaction(function () use ($value) {

					$password  = "Login@123";

					$user_id = DB::table('users')->insertGetId([
						'name' => $value['user_name'],
						'email' => $value['email'],
						'password' => bcrypt($password),
						'array_roles' => $value['screen_role_id'],
						'project_role_id' => $value['project_role_id'],
						'array_dashboard_list' => 1,
						'designation_id' => $value['designation_id'],
						'created_at' => NOW()
					]);
					//            $departmentid = $value['department_id'];

					//            $user_department = DB::select("select * from document_categories where department_id = $departmentid and active_flag = 1 ");

					//            if ($user_department != [] ) {

					//                $parent_id = DB::select("select * from document_folder_structures where document_folder_structure_id = $departmentid ");

					//                $directorate_id = $parent_id[0]->parent_document_folder_structure_id;

					//                $user_departments_id = DB::table('user_departments')->insertGetId([
					//                 'user_id' => $user_id,
					//                 'parent_node_id' => 2,
					//                 'directorate_id' => $directorate_id,
					//                 'department_id' => $value['department_id'],
					//                 'designation_id' => $value['designation_id'],
					//                             //'array_department' => $unique_array_department[$i]
					//             ]);


					//                $screenidcount1 = count($user_department);


					//                for ($w=0; $w < $screenidcount1; $w++) {           
					//                    $node1 = 'node1';

					//                    $directorate_id_cat = $user_department[$w]->directorate_id;
					//                    $department_id_cat = $user_department[$w]->department_id;
					//                    $document_category_id = $user_department[$w]->document_category_id;

					//                    $arr = $node1.'-'.$directorate_id_cat.'-'.$department_id_cat.'-'.$document_category_id;

					//                    $user_departments_id = DB::table('users_document_categories')->insertGetId([
					//                     'user_id' => $user_id,
					//                     'document_category_id' => $document_category_id,
					//                     'directorate_id' => $directorate_id_cat,
					//                     'department_id' => $department_id_cat,
					//                     'array_department' => $arr,
					//                 ]);
					//                };

					//            }


					//   $common_share_folder_id = config('setting.common_share_folder_id');

					//             $departmentid =  $common_share_folder_id;

					//            $user_department = DB::select("select * from document_categories where department_id = $departmentid and active_flag = 1 ");

					//            if ($user_department != [] ) {

					//                $parent_id = DB::select("select * from document_folder_structures where document_folder_structure_id = $departmentid ");

					//                $directorate_id = $parent_id[0]->parent_document_folder_structure_id;

					//                $user_departments_id = DB::table('user_departments')->insertGetId([
					//                 'user_id' => $user_id,
					//                 'parent_node_id' => 2,
					//                 'directorate_id' => $directorate_id,
					//                 'department_id' => $value['department_id'],
					//                 'designation_id' => $value['designation_id'],
					//                             //'array_department' => $unique_array_department[$i]
					//             ]);


					//                $screenidcount1 = count($user_department);


					//                for ($g=0; $g < $screenidcount1; $g++) {           
					//                    $node1 = 'node1';

					//                    $directorate_id_cat = $user_department[$g]->directorate_id;
					//                    $department_id_cat = $user_department[$g]->department_id;
					//                    $document_category_id = $user_department[$g]->document_category_id;

					//                    $arr = $node1.'-'.$directorate_id_cat.'-'.$department_id_cat.'-'.$document_category_id;

					//                    $user_departments_id = DB::table('users_document_categories')->insertGetId([
					//                     'user_id' => $user_id,
					//                     'document_category_id' => $document_category_id,
					//                     'directorate_id' => $directorate_id_cat,
					//                     'department_id' => $department_id_cat,
					//                     'array_department' => $arr,
					//                 ]);
					//                };

					//            }










					$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
						'user_id' => $user_id,
						'user_dashboard_list_id' => 1,
						'active_flag' => 0,
						'created_by' => $user_id,
					]);

					$role_change_id = DB::table('userrole_audit')
						->insertGetId([
							'current_role_id' => $value['screen_role_id'],
							'user_id' => $user_id,
							'created_by' => auth()->user()->id,
							'audit_status' => "Newly Added"
						]);

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'User Created',
						'notification_url' => 'user',
						'megcontent' => "User " . $value['user_name'] . " created Successfully and mail sent.",
						'alert_meg' => "User " . $value['user_name'] . " created Successfully and mail sent.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);


					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $value['screen_role_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);

					$role_id = $value['screen_role_id'];

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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							} else {
							}
						};
					};

					$role_id = $value['screen_role_id'];

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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};

					$last_name =  "A";
					$user_name  = $value['user_name'];
					$email =  $value['email'];

					// $response = [
					//     'userID' => $user_id,
					//     'firstName' => $value['user_name'],
					//     'lastName' => $last_name,
					//     'emailID' => $value['email'],
					// ];  
					//ncryptArray = $this->encryptData($response);

					// $documentController = new DocumentController;
					// $ticketResponse = $documentController->CreateDocumentSiteUserBulk($user_id,$last_name,$email,$user_name);



					// $truncate =  DB::select("TRUNCATE TABLE  users_dummy");


				});
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

	public function checking_data(Request $request)
	{

		try {
			$method = 'Method => DesignationController => checking_data';
			$inputArray = $this->decryptData($request->requestData);

			// role checking

			if ($inputArray['checking'] == 1) {

				$role_id = $inputArray['screen_role_id'];

				$role_check =  DB::select("select * from uam_roles where role_id = $role_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// project role checking



			if ($inputArray['checking'] == 2) {

				$project_role_id = $inputArray['project_role_id'];

				$role_check =  DB::select("select * from project_roles where project_role_id = $project_role_id and active_flag = 1");

				if ($role_check != []) {
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
			}



			// designation checking


			if ($inputArray['checking'] == 3) {

				$designation_id = $inputArray['designation_id'];

				$role_check =  DB::select("select * from designation where designation_id = $designation_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// department checking

			if ($inputArray['checking'] == 4) {

				$parent_department = config('setting.parent_department');

				$role_check =  DB::select("SELECT * FROM document_folder_structures WHERE parent_document_folder_structure_id Not IN  ($parent_department) AND active_flag = 1
 AND  document_folder_structure_id =  $department_id");




				if ($role_check != []) {
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
			}


			if ($inputArray['checking'] == 5) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users WHERE email = '$email' ");

				if ($role_check == []) {
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
			}


			if ($inputArray['checking'] == 6) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users_dummy WHERE email = '$email' ");
				$checkcounting = count($role_check);
				if ($checkcounting > 1) {

					$serviceResponse = array();
					$serviceResponse['Code'] = 400;
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				} else {
					$serviceResponse = array();
					$serviceResponse['Code'] = config('setting.status_code.success');
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				}
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
}
