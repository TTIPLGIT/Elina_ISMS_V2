<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\SailEmailAccept;
use App\Mail\QuestionnairerequestMail;
use App\Mail\QuestionnairerequestMail1;


class ParentsQuestionnaireController extends BaseController
{
	public function index()
	{
		try {
			$method = 'Method => ParentsQuestionnaireController => index';
			$userID = auth()->user()->id;

			$initiated_form = DB::table('questionnaire_initiation as qi')
				->select(
					'qi.status as currentState',
					DB::raw('COUNT(*) as total_questions'),
					'q.questionnaire_name',
					'qi.questionnaire_id',
					'qi.question_progress',
					'qi.questionnaire_initiation_id',
					'ed.enrollment_child_num',
					'qi.p_flag'
				)
				->join('questionnaire_details as qd', 'qd.questionnaire_id', '=', 'qi.questionnaire_id')
				->join('questionnaire as q', 'q.questionnaire_id', '=', 'qd.questionnaire_id')
				->join('enrollment_details as ed', 'ed.enrollment_id', '=', 'qi.enrollment_id')
				->leftJoin('question_details as qdq', 'qdq.questionnaire_details_id', '=', 'qd.questionnaire_details_id')
				->where('qi.activeflag', 0)
				->where('qdq.enable_flag', 1)
				->where('qdq.questionnaire_field_types_id', '!=', 9)
				->where('ed.user_id', $userID)
				->groupBy('qdq.questionnaire_details_id', 'qi.status', 'q.questionnaire_name', 'qi.questionnaire_id', 'qi.question_progress', 'qi.questionnaire_initiation_id', 'ed.enrollment_child_num', 'qi.p_flag')
				->orderBy('qi.questionnaire_initiation_id', 'desc')
				->get();

			if (!$initiated_form->isEmpty()) {
				// $this->WriteFileLog('in');
				$enrollment_child_num = $initiated_form[0]->enrollment_child_num;
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

			// 0-> Show
			// 1-> Hide
			// $this->WriteFileLog($sail);

			$response = [
				'initiated_form' => $initiated_form,
				'sail' => $sail
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
	public function getdata()
	{
		try {
			$method = 'Method => ParentsQuestionnaireController => get_data';
			// $this->WriteFileLog($method);
			$question_details = DB::select("SELECT * FROM question_details WHERE active_flag=1");
			// $questionnaire_list = DB::select("SELECT * FROM questionnaire WHERE active_flag=0");
			$check = DB::select("SELECT * FROM question_process WHERE questionnaire_initiation_id = 20");

			if ($check == []) {
				$question = DB::select("SELECT * FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
				WHERE qi.questionnaire_initiation_id=20 AND qd.active_flag=1 AND qd.enable_flag=1");
			} else {
				$question = DB::select("SELECT qd.question , qd.question_field_name , qft.questionnaire_field_types_id, qd.question_details_id, qp.* FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
				INNER JOIN question_process AS qp ON qp.questionnaire_initiation_id=qi.questionnaire_initiation_id
				WHERE qi.questionnaire_initiation_id=20 AND qd.active_flag=1 AND qd.enable_flag=1");
			}

			$answers = DB::select("SELECT * FROM question_process WHERE questionnaire_initiation_id = 19");

			$response = [
				'question_details' => $question_details,
				'question' => $question,
				'answers' => $answers
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
	public function GetAllQuestionnaireFields(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllQuestionnaireFields';
		try {
			$inputArray = $this->DecryptData($request->requestData);
			$input = [
				'questionnaireID' => $inputArray['questionnaireID'],
			];

			$rules = [
				'questionnaireID' => 'required | numeric',
			];

			$messages = [
				'questionnaireID.required' => 'QuestionnaireID is required.'
			];
			// $this->WriteFileLog($input);
			$validator = Validator::make($input, $rules, $messages);

			if ($validator->fails()) {
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.validation');
				$serviceResponse['Message'] = $validator->errors()->first();
				$serviceResponse = json_encode($serviceResponse);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), false);
				return $sendServiceResponse;
			}

			$question_details = DB::select("SELECT qd.question , qd.question_field_name , qft.questionnaire_field_types_id, qd.question_details_id FROM question_details AS qd 
			LEFT JOIN questionnaire_field_types AS qft ON qd.questionnaire_field_types_id=qft.questionnaire_field_types_id
			WHERE qd.questionnaire_details_id=15");

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $question_details;
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
	public function GetAllDropdownOptions(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllDropdownOptions';
		// $this->WriteFileLog($logMethod);
		try {
			$fieldID = $request->fieldID;
			$fieldOptions = DB::table('option_question_fields')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('option_question_fields_id', 'question_details_id', 'option_for_question')
				->get();

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $fieldOptions;
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
	public function GetAllRadioOptions(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllRadioOptions';
		try {
			// $this->WriteFileLog($request->fieldID);

			$fieldID = $request->fieldID;
			$fieldOptions = DB::table('option_question_fields')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('option_question_fields_id', 'question_details_id', 'option_for_question')
				->get();

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $fieldOptions;
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
	public function GetAllCheckBoxOptions(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllCheckBoxOptions';
		try {
			// $this->WriteFileLog($request->fieldID);

			$fieldID = $request->fieldID;
			$fieldOptions = DB::table('option_question_fields')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('option_question_fields_id', 'question_details_id', 'option_for_question')
				->get();

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $fieldOptions;
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
	public function GetAllSubQuestionDropdownBoxOptions(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllSubQuestionDropdownBoxOptions';
		try {
			// $this->WriteFileLog($request->fieldID);

			$fieldID = $request->fieldID;
			$fieldOptions = DB::table('option_question_fields')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('option_question_fields_id', 'question_details_id', 'option_for_question')
				->get();

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $fieldOptions;
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
	public function GetAllSubQuestionRadioOptions(Request $request)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => GetAllSubQuestionRadioOptions';
		try {
			// $this->WriteFileLog($request->fieldID);

			$fieldID = $request->fieldID;
			$fieldOptions = DB::table('option_question_fields')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('option_question_fields_id', 'question_details_id', 'option_for_question')
				->get();

			$fieldQuestions = DB::table('sub_questions')
				->where('active_flag', 1)
				->where('question_details_id', $fieldID)
				->select('sub_questions_id', 'question_details_id', 'sub_question')
				->get();

			$response = [
				'fieldOptions' => $fieldOptions,
				'fieldQuestions' => $fieldQuestions
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

	public function QuestionnaireFormSave(Request $request)
	{

		$logMethod = 'Method => ParentsQuestionnaireController => QuestionnaireFormSave';

		try {

			$userID = auth()->user()->id;
			$inputArray = $this->DecryptData($request->requestData);

			$data = $inputArray['data'];
			$url = $inputArray['url'];

			$arraydata = array();
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$dd = json_encode($value);
					$arraydata[$key] = $dd;
				} else {
					$arraydata[$key] = $value;
				}
			}

			// $this->WriteFileLog($arraydata);
			// $this->WriteFileLog(count($arraydata));

			$arraydata2 = \array_diff_key($arraydata, ["complete_question" => "xy"]);
			$initiationID = $data['questionnaire_initiation_id'];
			$complete_question = $data['complete_question'];
			$progress_status = $data['progress_status'];
			$data21 = array_merge($arraydata2, array("created_by" => $userID, "last_modified_by" => $userID, "active_flag" => "1", "last_modified_at" => NOW(), "created_at" => NOW()));
			$table = DB::select("SELECT b.table_name FROM questionnaire_initiation AS a 
			INNER JOIN questionnaire AS b ON b.questionnaire_id=a.questionnaire_id
			WHERE questionnaire_initiation_id = $initiationID");
			$table_name = $table[0]->table_name;
			if ($table_name == '') {
				$table_name = 'question_process';
			}
			$check = DB::select("SELECT * FROM " . $table_name . " WHERE questionnaire_initiation_id = $initiationID");
			// $this->WriteFileLog($data21);
			if ($check == []) {
				$formSave = DB::table($table_name)->insertGetId($data21);
			} else {
				DB::table($table_name)
					->where('questionnaire_initiation_id', $initiationID)
					->update($data21);
			}


			// foreach ($arraydata as $key => $value) {
			// 	if (is_null($value) || $value == '') unset($arraydata[$key]);
			// 	elseif ($key == 'questionnaire_initiation_id') unset($arraydata[$key]);
			// 	elseif ($key == 'progress_status') unset($arraydata[$key]);
			// 	elseif ($key == 'complete_question') unset($arraydata[$key]);
			// }

			// $question_progress = count($arraydata);		

			if ($progress_status == 'submit') {

				$progress_status = 'Submitted';
				$QI = DB::select("SELECT * FROM enrollment_details WHERE user_id=$userID");
				$ch = $QI[0]->child_name;
				$vv = $QI[0]->enrollment_child_num;
				$vv1 = $QI[0]->enrollment_id;
				$cce = $QI[0]->child_contact_email;
				$quesDetails = DB::select("SELECT * FROM questionnaire AS a INNER JOIN questionnaire_initiation AS b ON b.questionnaire_id=a.questionnaire_id
				WHERE b.questionnaire_initiation_id = $initiationID");
				$quesDetailsName = $quesDetails[0]->questionnaire_name;
				$quesDetailsType = $quesDetails[0]->questionnaire_type;
				// if ($quesDetailsType == 'OVM' && $quesDetailsName == 'Parent Feedback Form') {
				// 	Mail::to($cce)->send(new SailEmailAccept($url));
				// }

				// $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
				$admin_details = DB::SELECT("SELECT * from users WHERE (array_roles = '4' 
				OR id IN (SELECT JSON_EXTRACT(is_coordinator1 , '$.id') AS id FROM sail_details WHERE enrollment_id = '$vv' )) 
				OR id IN ((SELECT is_coordinator1 AS id FROM ovm_allocation WHERE enrollment_id = '$vv1' ))
				OR id IN ((SELECT is_coordinator2 AS id FROM ovm_allocation WHERE enrollment_id = '$vv1' ))");
				$adminn_count = count($admin_details);
				if ($admin_details != []) {
					for ($j = 0; $j < $adminn_count; $j++) {

						DB::table('notifications')->insertGetId([
							'user_id' =>  $admin_details[$j]->id,
							'notification_type' => 'Questionnaire',
							'notification_status' => 'Questionnaire Submitted',
							'notification_url' => 'questionnaire/submitted/form/' . encrypt($initiationID),
							'megcontent' => $quesDetails[0]->questionnaire_name . " received from " . $ch . " (" . $vv . ")",
							'alert_meg' => $quesDetails[0]->questionnaire_name . " received from " . $ch . " (" . $vv . ")",
							'created_by' => auth()->user()->id,
							'created_at' => NOW()
						]);
					}
				}
			} else {
				$progress_status = 'Save';
			}

			$totalQue = DB::select("SELECT no_questions FROM questionnaire AS a 
			inner join questionnaire_details AS que ON que.questionnaire_id=a.questionnaire_id
			INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
			WHERE qi.questionnaire_initiation_id=$initiationID");
			$totalQueNum = $totalQue[0]->no_questions - $complete_question;
			DB::table('questionnaire_initiation')
				->where('questionnaire_initiation_id', $initiationID)
				->update([
					'question_progress' => $complete_question,
					'status' => $progress_status
				]);

			$serviceResponse['Code'] = config('setting.status_code.created');
			$serviceResponse['Message'] = 'Successfully.';
			$serviceResponse['Data'] = $initiationID;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.created'), true);
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

	public function data_edit($id)
	{
		$logMethod = 'Method => ParentsQuestionnaireController => data_edit';

		try {
			$id = $this->decryptData($id);
			// $this->WriteFileLog('check_');
			// $this->WriteFileLog($id);
			$table = DB::select("SELECT b.table_name FROM questionnaire_initiation AS a 
			INNER JOIN questionnaire AS b ON b.questionnaire_id=a.questionnaire_id
			WHERE questionnaire_initiation_id = $id");
			$table_name = $table[0]->table_name;
			if ($table_name == '') {
				$table_name = 'question_process';
			}
			$check = DB::select("SELECT * FROM " . $table_name . " WHERE questionnaire_initiation_id = $id");
			// $this->WriteFileLog($check);
			$questionDetails = DB::select("SELECT * FROM questionnaire AS a 
			inner join questionnaire_details AS que ON que.questionnaire_id=a.questionnaire_id
			INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
			WHERE qi.questionnaire_initiation_id=$id");
			// $this->WriteFileLog('1');
			if ($check == []) {
				$question = DB::select("SELECT qd.questionnaire_field_types_id ,question_details_id,question,question_field_name,questionnaire_description, qd.required, qd.other_option, qd.question_description FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
				WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1 ORDER BY question_order ASC ");

				$view = 'new';
				$submit_status = 'new';
			} else {
				$question = DB::select("SELECT qp.progress_status AS submit_status, qd.question , qd.question_field_name , qft.questionnaire_field_types_id, qd.other_option , qd.required , qd.question_details_id, qd.question_description, qp.* FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
				INNER JOIN " . $table_name . " AS qp ON qp.questionnaire_initiation_id=qi.questionnaire_initiation_id
				WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1 ORDER BY question_order ASC ");

				$submit_status = $question[0]->submit_status;
				$view = 'update';
			}

			$fieldOptions = DB::select("SELECT * FROM option_question_fields 
			WHERE question_details_id IN (SELECT question_details_id FROM question_details AS qd 
			INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
			INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
			INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
			WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1)");

			$fieldQuestions = DB::select("SELECT * FROM sub_questions 
			WHERE question_details_id IN (SELECT question_details_id FROM question_details AS qd 
			INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
			INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
			INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
			WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1)");

			$question_details = DB::select("SELECT * FROM question_details WHERE active_flag=1");

			$fieldQuestions = [
				'fieldOptions' => $fieldOptions,
				'fieldQuestions' => $fieldQuestions
			];
			$questionnaire_id = $questionDetails[0]->questionnaire_id;

			$options = DB::table('quadrant_questionnaire')
				->select('*')
				->where('questionnaire_id', $questionnaire_id)
				->get();
			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role = $role_name[0]->role_name;
			$response = [
				'question' => $question,
				'question_details' => $question_details,
				'view' => $view,
				'submit_status' => $submit_status,
				'fieldOptions' => $fieldOptions,
				'fieldQuestions' => $fieldQuestions,
				'questionDetails' => $questionDetails,
				'options' => $options,
				'role' => $role
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

	public function GetAllSubmittedForm()
	{
		try {
			$method = 'Method => ParentsQuestionnaireController => index';
			$userID = auth()->user()->id;

			$submitted_form = DB::select("SELECT qi.questionnaire_initiation_id, Q.questionnaire_name, ed.child_name,  ed.enrollment_child_num
			FROM questionnaire_initiation AS qi
			INNER JOIN questionnaire_details AS qd ON qd.questionnaire_id=qi.questionnaire_id
			INNER JOIN questionnaire AS Q ON Q.questionnaire_id=qd.questionnaire_id
			INNER JOIN question_process AS qp ON qp.questionnaire_initiation_id=qi.questionnaire_initiation_id
			INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
			WHERE qp.progress_status='submit'");

			$response = [
				'submitted_form' => $submitted_form,
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

	public function SubmittedForm($id)
	{

		$logMethod = 'Method => QuestionCreationController => data_edit';

		try {
			$id = $this->decryptData($id);
			// $this->WriteFileLog($id);

			$enrollmentDetails = DB::select("SELECT b.* FROM questionnaire_initiation AS a
			INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
			WHERE a.questionnaire_initiation_id=$id");

			$questionDetails = DB::select("SELECT * FROM questionnaire AS a 
			inner join questionnaire_details AS que ON que.questionnaire_id=a.questionnaire_id
			INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
			WHERE qi.questionnaire_initiation_id=$id");

			$table = DB::select("SELECT b.table_name FROM questionnaire_initiation AS a 
			INNER JOIN questionnaire AS b ON b.questionnaire_id=a.questionnaire_id
			WHERE questionnaire_initiation_id = $id");
			$table_name = $table[0]->table_name;
			if ($table_name == '') {
				$table_name = 'question_process';
			}

			$question = DB::select("SELECT qd.question , qd.question_field_name , qft.questionnaire_field_types_id, qd.question_details_id, qp.* ,  qd.required, qd.other_option FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
				INNER JOIN " . $table_name . " AS qp ON qp.questionnaire_initiation_id=qi.questionnaire_initiation_id
				WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1 ORDER BY question_order ASC ");
			$fieldOptions = DB::select("SELECT * FROM option_question_fields 
				WHERE question_details_id IN (SELECT question_details_id FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1)");

			$fieldQuestions = DB::select("SELECT * FROM sub_questions 
				WHERE question_details_id IN (SELECT question_details_id FROM question_details AS qd 
				INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
				INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
				INNER JOIN questionnaire_initiation AS qi ON qi.questionnaire_id=que.questionnaire_id
				WHERE qi.questionnaire_initiation_id=$id AND qd.active_flag=1 AND qd.enable_flag=1)");

			$question_details = DB::select("SELECT * FROM question_details WHERE active_flag=1");

			$fieldQuestions = [
				'fieldOptions' => $fieldOptions,
				'fieldQuestions' => $fieldQuestions
			];

			$question_details = DB::select("SELECT * FROM question_details WHERE active_flag=1");
			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role = $role_name[0]->role_name;

			$qi = DB::Select("select viewed_users from questionnaire_initiation where questionnaire_initiation_id = $id");
			$viewed = $qi[0]->viewed_users;
			$authId = auth()->user()->id;

			if ($viewed == '') {
				$stringuser_id = $authId;
			} else {
				$che = array($viewed);
				if (in_array($authId, $che)) {
					$stringuser_id = $viewed;
				} else {
					$stringuser_id = $viewed . ',' . $authId;
				}
			}


			DB::table('questionnaire_initiation')
				->where('questionnaire_initiation_id', $id)
				->update([
					'viewed_users' => $stringuser_id,
				]);

			$response = [
				'question' => $question,
				'question_details' => $question_details,
				'fieldOptions' => $fieldOptions,
				'fieldQuestions' => $fieldQuestions,
				'role' => $role,
				'questionDetails' => $questionDetails,
				'enrollmentDetails' => $enrollmentDetails
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

	public function GraphGetdata(Request $request)

	{
		$logMethod = 'Method => ParentsQuestionnaireController => activityajax';

		try {

			$inputArray = $request->requestData;
			$inputArray = $this->DecryptData($request->requestData);
			$input = [
				'from' => $inputArray['from'],
				'to' => $inputArray['to'],
			];

			// $this->WriteFileLog($input);
			$from = $input['from'];
			$to = $input['to'];
			$columnarray = DB::select("SELECT GROUP_CONCAT(concat(question_field_name) SEPARATOR ',') as col FROM question_details 
			WHERE questionnaire_details_id=8 AND active_flag=1 AND enable_flag=1 AND questionnaire_field_types_id != 2 OR question_details_id = 109");
			$column = $columnarray[0]->col;
			$data = DB::select("SELECT $column FROM questionnaire_initiation AS que 
			INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id
			INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id 
			INNER JOIN question_process AS qpp ON qpp.questionnaire_initiation_id=que.questionnaire_initiation_id
			WHERE que.activeflag=0 AND qud.questionnaire_type = 'OVM' AND que.status = 'Submitted' 
			AND DATE_FORMAT(last_modified_at , '%d-%m-%Y') BETWEEN '$from' AND '$to' ");
			$fieldTypes = DB::select("SELECT question, questionnaire_field_types_id , question_field_name FROM question_details 
			WHERE questionnaire_details_id=8 AND active_flag=1 AND enable_flag=1 AND questionnaire_field_types_id != 2 OR question_details_id = 109");
			$response = [
				'data' => $data,
				'fieldTypes' => $fieldTypes,
			];
			// $this->WriteFileLog($data);
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] =  $response;
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

	public function sensoryreport($id)
	{

		$logMethod = 'Method => QuestionCreationController => data_edit';

		try {
			$id = $this->decryptData($id);

			$check = ['Frequently = 4', 'Half the Time = 3', 'Almost Always = 5'];

			// Fetch answers for the given ID
			$answers = DB::table('sensory_profiling_question')
				->where('questionnaire_initiation_id', $id)
				->first();

			// Fetch questions related to the questionnaire
			$questions = DB::table('question_details as a')
				->join('questionnaire_details as b', 'b.questionnaire_details_id', '=', 'a.questionnaire_details_id')
				->join('questionnaire_initiation as c', 'c.questionnaire_id', '=', 'b.questionnaire_id')
				->join('questionnaire as d', 'd.questionnaire_id', '=', 'b.questionnaire_id')
				->where('c.questionnaire_initiation_id', $id)
				->where('questionnaire_field_types_id', 3)
				->select('c.questionnaire_id', 'a.question_field_name', 'a.question', 'a.quadrant', 'a.quadrant_type', 'd.questionnaire_name')
				->get();

			$questionnaireID = $questions->first()->questionnaire_id;

			// Fetch quadrant options
			$quadrant_option = DB::table('quadrant_questionnaire')
				->where('questionnaire_id', $questionnaireID)
				->where('value', '>=', 3)
				->get();

			$finalquestions = [];
			$questionNumber = 1;

			foreach ($questions as $question) {
				$field_name = $question->question_field_name;
				$v = $answers->$field_name ?? '';

				if (in_array($v, $check)) {
					foreach ($quadrant_option as $val) {
						$Q_Option = $val->option . ' = ' . $val->value;
						if ($Q_Option == $v) {
							$question->value = $val->value;
						}
					}

					$question->question_number = $questionNumber;
					$questionNumber++;

					$finalquestions[] = $question;
				}
			}

			$enrollmentDetails = DB::table('enrollment_details as a')
				->join('questionnaire_initiation as b', 'b.enrollment_id', '=', 'a.enrollment_id')
				->where('b.questionnaire_initiation_id', $id)
				->value('child_name');

			$response = [
				'questions' => $finalquestions,
				'child_name' => $enrollmentDetails
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

	public function executive_report($id)
	{

		$logMethod = 'Method => QuestionCreationController => data_edit';

		try {
			$id = $this->decryptData($id);

			$enrollmentDetails = DB::select("SELECT a.enrollment_id , a.child_name FROM enrollment_details AS a INNER JOIN questionnaire_initiation AS b ON b.enrollment_id=a.enrollment_id WHERE questionnaire_initiation_id = $id");
			$enrollmentID = $enrollmentDetails[0]->enrollment_id;

			// $this->WriteFileLog($id);
			$check = array('Almost Never', 'Sometimes');
			$answers = DB::select("SELECT * FROM sail_executivefunctioningquestionnaire WHERE questionnaire_initiation_id = $id");

			$questions = DB::select("SELECT b.questionnaire_id , a.question_field_name , a.question , a.quadrant , a.quadrant_type , d.questionnaire_name FROM question_details AS a 
			INNER JOIN questionnaire_details AS b ON b.questionnaire_details_id=a.questionnaire_details_id
			INNER JOIN questionnaire_initiation AS c ON c.questionnaire_id = b.questionnaire_id
			INNER JOIN questionnaire AS d ON d.questionnaire_id = b.questionnaire_id
			WHERE c.questionnaire_initiation_id=$id AND questionnaire_field_types_id = 8");

			$questionnaire_quadrant_id = $questions[0]->questionnaire_id;
			$questionnaire_quadrant = DB::select("SELECT field FROM questionnaire_quadrant_category WHERE questionnaire_id = $questionnaire_quadrant_id");

			$fields = array();
			$finalquestions = array();

			foreach ($questionnaire_quadrant as $row) {
				$fields[$row->field] = array();
				$finalquestions[$row->field] = array();
				$finalquestions[$row->field]['Strength'] = array();
				$finalquestions[$row->field]['Stretches'] = array();
			}

			for ($i = 0; $i < count($questions); $i++) {
				$quadrant = $questions[$i]->quadrant;
				foreach ($fields as $f => $field) {
					if ($quadrant == $f) {
						array_push($fields[$f], $questions[$i]);
					}
				}
			}

			for ($i = 0; $i < count($questions); $i++) {
				$field_name = $questions[$i]->question_field_name;
				$quadrant = $questions[$i]->quadrant;
				$v = $answers[0]->$field_name;
				if (in_array($v, $check)) {
					array_push($finalquestions[$quadrant]['Strength'], $questions[$i]);
				} else {
					array_push($finalquestions[$quadrant]['Stretches'], $questions[$i]);
				}
			}
			// Child 


			$check1 = array('Strongly disagree - 1', 'Disagree - 2', 'Tend to disagree - 3');

			$questions1 = DB::select("SELECT c.questionnaire_initiation_id , a.question_field_name , a.question , a.quadrant , a.quadrant_type , d.questionnaire_name FROM question_details AS a 
			INNER JOIN questionnaire_details AS b ON b.questionnaire_details_id=a.questionnaire_details_id
			INNER JOIN questionnaire_initiation AS c ON c.questionnaire_id = b.questionnaire_id
			INNER JOIN questionnaire AS d ON d.questionnaire_id = b.questionnaire_id
			WHERE questionnaire_field_types_id = 3 AND c.enrollment_id = $enrollmentID AND c.questionnaire_id = 11");
			if (!empty($questions1)) {
				$qID = $questions1[0]->questionnaire_initiation_id;

				$answers1 = DB::select("SELECT * FROM the_way_i_process_questionnaire WHERE questionnaire_initiation_id = $qID");
			} else {
				$answers1 = [];
			}
			if ($answers1 != []) {
				$fields1 = array();
				$finalquestions1 = array();

				foreach ($questionnaire_quadrant as $row) {
					$fields1[$row->field] = array();
					$finalquestions1[$row->field] = array();
					$finalquestions1[$row->field]['Strength'] = array();
					$finalquestions1[$row->field]['Stretches'] = array();
				}

				for ($i = 0; $i < count($questions1); $i++) {
					$quadrant1 = $questions1[$i]->quadrant;
					foreach ($fields1 as $f1 => $field) {
						if ($quadrant1 == $f1) {
							array_push($fields1[$f1], $questions1[$i]);
						}
					}
				}

				for ($i = 0; $i < count($questions1); $i++) {
					$field_name1 = $questions1[$i]->question_field_name;
					$quadrant1 = $questions1[$i]->quadrant;
					$v1 = $answers1[0]->$field_name1;
					if ($v1 != 'Not Applicable') {
						if (!in_array($v1, $check1)) {
							array_push($finalquestions1[$quadrant1]['Strength'], $questions1[$i]);
						} else {
							array_push($finalquestions1[$quadrant1]['Stretches'], $questions1[$i]);
						}
					}
				}
			} else {
				$finalquestions1 = '';
			}

			$respond = [
				'parent' => $finalquestions,
				'child' => $finalquestions1,
			];



			$response = [
				'questions' => $respond,
				'child_name' => $enrollmentDetails[0]->child_name
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
	public function upload_update(Request $request)
	{
		try {
			$method = 'Method =>  ParentsQuestionnaireController => upload_update';

			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'enrollment_id' => $inputArray['enrollment_id'],
				'questionnaire_initiation_id' => $inputArray['questionnaire_initiation_id'],
			];
			$initiationID = $input['questionnaire_initiation_id'];
			$en_id_num = $input['enrollment_id'];
			
			$enrollment = DB::select("SELECT enrollment_id FROM enrollment_details WHERE enrollment_child_num=?", [$en_id_num]);
			$en_id = $enrollment[0]->enrollment_id;
			$table = DB::select("SELECT b.table_name FROM questionnaire_initiation AS a 
				INNER JOIN questionnaire AS b ON b.questionnaire_id=a.questionnaire_id
				WHERE a.questionnaire_initiation_id = $initiationID and enrollment_id=$en_id");
			$table_name = $table[0]->table_name;
			
			if ($table_name == '') {
				$table_name = 'question_process';
			}
			$check = DB::select("SELECT * FROM " . $table_name . " WHERE questionnaire_initiation_id = $initiationID");
			if ($check == []) {
				$formSave = DB::table($table_name)->update(['status' => 'save']);
			} else {
				DB::table($table_name)
					->where('questionnaire_initiation_id', $initiationID)
					->update(['progress_status' => 'save']);
				DB::table('questionnaire_initiation')
					->where('questionnaire_initiation_id', $initiationID)
					->update(['status' => 'Save']);
			}

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 200;
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
	public function upload_update_parent(Request $request)
	{
		try {
			$method = 'Method =>  ParentsQuestionnaireController => upload_update_parent';

			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'enrollment_id' => $inputArray['enrollment_id'],
				'questionnaire_initiation_id' => $inputArray['questionnaire_initiation_id'],
				'que_id' => $inputArray['que_id'],
			];
			$initiationID = $input['questionnaire_initiation_id'];
			$q_id = $input['que_id'];
			$en_id_num = $input['enrollment_id'];

			$enrollment = DB::select("SELECT enrollment_id,child_name FROM enrollment_details WHERE enrollment_child_num=?", [$en_id_num]);
			$en_id = $enrollment[0]->enrollment_id;
			$table = DB::select("SELECT questionnaire_name FROM questionnaire AS a 
				INNER JOIN questionnaire_initiation AS b ON b.questionnaire_id=a.questionnaire_id
				WHERE b.questionnaire_initiation_id = $initiationID and enrollment_id=$en_id");
			$table_name = $table[0]->questionnaire_name;
			
			$admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
			$noti = DB::select("SELECT * FROM sail_details WHERE enrollment_id ='$en_id_num'");
			$coID1 = $noti[0]->is_coordinator1;

			$user_data = json_decode($coID1, true);
			$user_id = $user_data['id'];

			// $this->WriteFileLog($user_id);
			$Co_details = DB::SELECT("SELECT * from users where id =$user_id");
			if ($user_id != '') {
				$user_email = $user_data['email'];
				DB::table('notifications')->insertGetId([
					'user_id' =>  $Co_details[0]->id,
					'notification_type' => 'Questionnaire',
					'notification_status' => 'Questionnaire Request',
					'notification_url' => 'sailquestionnairelistview',
					'megcontent' => "{$noti[0]->child_name} ({$noti[0]->enrollment_id}) has requested edit access for the Questionnaire - {$table_name}",
					'alert_meg' => "{$noti[0]->child_name} ({$noti[0]->enrollment_id}) has requested edit access for the Questionnaire - {$table_name}",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				// $mail_sub = "Parent Request Questionnaire";
				$mail_sub = "Request for Questionnaire Edit " . $table_name;
				$data = array(
					'child_name' => $enrollment[0]->child_name,
					'questionnaire_name' => $table_name,
					'mail_subject' => $mail_sub
				);

				Mail::to($user_email)->send(new QuestionnairerequestMail($data));
			}

			DB::table('questionnaire_initiation')
				->where('questionnaire_id', $q_id)
				->where('enrollment_id', $en_id)
				->update(['p_flag' => '1']);

			$coID2 = $noti[0]->is_coordinator2;
			$user_data1 = json_decode($coID2, true);
			$user_id1 = $user_data1['id'];
			$Co_details2 = DB::SELECT("SELECT * from users where id =$user_id1");
			if ($user_id1 != '') {
				$user_email1 = $user_data1['email'];
				DB::table('notifications')->insertGetId([
					'user_id' =>  $Co_details2[0]->id,
					'notification_type' => 'Questionnaire',
					'notification_status' => 'Questionnaire Request',
					'notification_url' => 'sailquestionnairelistview',
					'megcontent' => "{$noti[0]->child_name} ({$noti[0]->enrollment_id}) has requested edit access for the Questionnaire - {$table_name}",
					'alert_meg' => "{$noti[0]->child_name} ({$noti[0]->enrollment_id}) has requested edit access for the Questionnaire - {$table_name}",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$mail_sub = "Parent Request Questionnaire";
				$data1 = array(
					'child_name' => $enrollment[0]->child_name,
					'questionnaire_name' => $table_name,
					'mail_subject' => $mail_sub
				);
				Mail::to($user_email1)->send(new QuestionnairerequestMail1($data1));
			}

			// $this->WriteFileLog("exit");
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 200;
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
