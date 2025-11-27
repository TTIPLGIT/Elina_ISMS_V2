<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\URL;

class ChildQuestionnaireController extends BaseController
{
	public function index(Request $request)
	{
		try {
			$method = 'Method => ChildQuestionnaireController => index';
			$user_idEnc = $request->session()->get("userID");
			// $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_for_parents/indexlist';
			// $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			// $response = json_decode($response);
			//if ($response->Status == 200 && $response->Success) {
				// $objData = json_decode($this->decryptData($response->Data));
				// if ($objData->Code == 200) {
				// 	$parant_data = json_decode(json_encode($objData->Data), true);
				// 	$initiated_form =  $parant_data['initiated_form'];
				// 	// dd($parant_data);
					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
				// 	$user_role = $modules['user_role'];
				// 	$sail = $parant_data['sail'];
				// 	$encUser = $this->encryptData($user_idEnc);

				// 	if ($user_role != 'Parent'|| $user_role != 'Child' ) {
				// 		return Redirect::back();
				// 	}
					return view('questionnaire_for_child.index', compact( 'modules', 'screens'));
				//}
			// } else {
			// 	$objData = json_decode($this->decryptData($response->Data));
			// 	echo json_encode($objData->Code);
			// 	exit;
			// }
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}
	public function dashboard(Request $request)
	{
		$user_id = $request->session()->get("userID");

		$method = 'Method => LoginController => Register_screen';
		$request =  array();
		$request['user_id'] = $user_id;

		$gatewayURL = config('setting.api_gateway_url') . '/user/dashboard';
		$response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

		$response = json_decode($response);

		if ($response->Status == 200 && $response->Success) {
			$objData = json_decode($this->decryptData($response->Data));

			if ($objData->Code == 200) {
				$parant_data = json_decode(json_encode($objData->Data), true);
				$rows =  $parant_data;
				$request =  array();
				$request['user_id'] = $user_id;
				$menus = $this->FillMenu($request);
				if ($menus == "401") {
					return redirect(route('/'))->with('errors', 'User session Exipired');
				}
				$screens = $menus['screens'];
				$modules = $menus['modules'];
				$user_role = $modules['user_role'];

				if ($user_role == 'Parent') {
					return redirect(route('newenrollment.create'));
				}
				return view('questionnaire_for_parents.dashboard', compact('screens', 'modules', 'rows'));
			}
		} elseif ($response->Status == 401) {

			return redirect(route('/'))->with('errors', 'User session Exipired');
		}
	}
	public function fill_form()
	{
		try {
			$method = 'Method => ChildQuestionnaireController => index';
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire_for_parents/getdata';
			$response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			$response = json_decode($response);
			if ($response->Status == 200 && $response->Success) {
				$objData = json_decode($this->decryptData($response->Data));
				if ($objData->Code == 200) {
					$parant_data = json_decode(json_encode($objData->Data), true);
					$question_details =  $parant_data['question_details'];
					$question = $parant_data['question'];
					$answers = $parant_data['answers']; //dd($answers);
					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
					return view('questionnaire_for_parents.fill_form', compact('answers', 'screens', 'modules', 'question_details', 'question'));
				}
			} else {
				$objData = json_decode($this->decryptData($response->Data));
				echo json_encode($objData->Code);
				exit;
			}
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}

	public function FormEdit($id)
	{ //echo $this->decryptData($id);exit;
		try {
			$method = 'Method => ChildQuestionnaireController => FormEdit';
			// $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_for_parents/editdata/' . $id;
			// $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			// $response = json_decode($response); //dd($response);
			// if ($response->Status == 200 && $response->Success) {
			// 	$objData = json_decode($this->decryptData($response->Data));
				// if ($objData->Code == 200) {
				// 	$parant_data = json_decode(json_encode($objData->Data), true);
				// 	$question_details =  $parant_data['question_details'];
				// 	$question = $parant_data['question'];
				// 	$currentstatus = $parant_data['view'];
				// 	$submit_status = $parant_data['submit_status'];
				// 	$fieldOptionsDB = $parant_data['fieldOptions'];
				// 	$fieldQuestionsDB = $parant_data['fieldQuestions'];
				// 	$questionDetails = $parant_data['questionDetails'];
				// 	$options = $parant_data['options'];
				// 	$role = $parant_data['role'];
				// 	$questionnaire_initiation_id = $this->decryptData($id);
					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
					// if ($currentstatus == 'new') {
						return view('questionnaire_for_child.fill_form', compact( 'screens', 'modules'));
				// 	} elseif ($currentstatus == 'update') {
				// 		if ($submit_status == 'save') {
				// 			return view('questionnaire_for_parents.edit_form', compact('role','options', 'questionDetails', 'fieldQuestionsDB', 'fieldOptionsDB', 'currentstatus', 'questionnaire_initiation_id', 'screens', 'modules', 'question_details', 'question'));
				// 		} elseif ($submit_status == 'submit') {
				// 			return redirect()->route('questionnaire.submitted.form', $id);
				// 			// return view('questionnaire_for_parents.edit_form', compact('currentstatus', 'questionnaire_initiation_id', 'screens', 'modules', 'question_details', 'question'));
				// 		}
				// 	}
				// }
			// } else {
			// 	$objData = json_decode($this->decryptData($response->Data));
			// 	echo json_encode($objData->Code);
			// 	exit;
			// }
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}

	public function GetAllQuestionnaireFields(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllQuestionnaireFields';
		try {
			$questionnaireID = $request->questionnaireID;
			$serviceRequest = array();
			$serviceRequest['questionnaireID'] = $questionnaireID;
			$encryptArray = $this->encryptData($serviceRequest);
			$serviceRequest = array();
			$serviceRequest['requestData'] = $encryptArray;
			$serviceRequest = json_encode($serviceRequest, JSON_FORCE_OBJECT);
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire_parents/fields/list';
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceRequest, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}
	public function GetAllDropdownOptions(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllDropdownOptions';
		try {
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/field/dropdown/option';

			$serviceResponse = array();
			$serviceResponse['fieldID'] = $request['fieldID'];
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}
	public function GetAllRadioOptions(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllRadioOptions';
		try {
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/field/radio/option';

			$serviceResponse = array();
			$serviceResponse['fieldID'] = $request['fieldID'];
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}
	public function GetAllCheckBoxOptions(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllCheckBoxOptions';
		try {
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/field/checkbox/option';

			$serviceResponse = array();
			$serviceResponse['fieldID'] = $request['fieldID'];
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}
	public function GetAllSubQuestionDropdownBoxOptions(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllSubQuestionDropdownBoxOptions';
		try {
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/field/subdropdown/option';

			$serviceResponse = array();
			$serviceResponse['fieldID'] = $request['fieldID'];
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}
	public function GetAllSubQuestionRadioOptions(Request $request)
	{
		$logMethod = 'Method => ChildQuestionnaireController => GetAllSubQuestionRadioOptions';
		try {
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/field/subradio/option';

			$serviceResponse = array();
			$serviceResponse['fieldID'] = $request['fieldID'];
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}

	public function QuestionnaireFormSubmit(Request $request)
	{

		$fetch_data = count($request->all());
		$data = json_decode(json_encode($request->all()), true);
		$demo = array();

		$logMethod = 'Method => ChildQuestionnaireController => QuestionnaireFormSubmit';
		try {

			$serviceRequest = array();
			$serviceRequest['folderPath'] = $data['folderPath'];
			$serviceRequest['documentSourceType'] = $data['documentSourceType'];
			$serviceRequest['documentCategory'] = $data['documentCategory'];
			$serviceRequest['documentSubject'] = $data['documentSubject'];
			$serviceRequest['documentReferenceNumber'] = $data['documentReferenceNumber'];
			$serviceRequest['documentDescription'] = $data['documentDescription'];
			$serviceRequest['data'] = $data;
			$serviceRequest['formData'] = $request->formData;
			$encryptArray = $this->encryptData($serviceRequest);
			$serviceRequest = array();
			$serviceRequest['requestData'] = $encryptArray;
			$serviceRequest = json_encode($serviceRequest, JSON_FORCE_OBJECT);
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/form/submit';
			$serviceResponse = $this->serviceRequest($gatewayURL, 'POST', $serviceRequest, $logMethod);

			$objSrviceResponse = json_decode($serviceResponse);
			$serviceResponse = $this->decryptData($objSrviceResponse->Data);
			echo $serviceResponse;
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}

	public function QuestionnaireFormSave(Request $request)
	{//dd($request);
		$logMethod = 'Method => ChildQuestionnaireController => ProcessingDocumentCreate';
		try {
			$btn_type = $request->progress_status;
			$restorePage = $request->restorePage;
			$restorePagination = $request->restorePagination;
			$restorepaginationPage = $request->restorepaginationPage;
			// dd($restorePage, $restorePagination, $restorepaginationPage);
			$data = $request->except('_token');
			unset($data['restorePage']);
			unset($data['restorePagination']);
			unset($data['restorepaginationPage']);
			// dd($data);
			$user_id = $request->session()->get("userID");
			$url = URL::signedRoute('signed.sail.initiate', ['user_id' => $this->encryptData($user_id)]);
			$serviceRequest = array();
			$serviceRequest['data'] = $data;
			$serviceRequest['url'] = $url;
			$encryptArray = $this->encryptData($serviceRequest);
			$serviceRequest = array();
			$serviceRequest['requestData'] = $encryptArray;
			$serviceRequest = json_encode($serviceRequest, JSON_FORCE_OBJECT);
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/form/save';
			$serviceResponse = $this->serviceRequest($gatewayURL, 'POST', $serviceRequest, $logMethod);

			$objSrviceResponse = json_decode($serviceResponse);
			$serviceResponse = json_decode($this->decryptData($objSrviceResponse->Data));
			if ($serviceResponse->Code == 201) {
				if ($btn_type == 'submit') {
					return redirect()->route('questionnaire_for_user.index')->with('success', 'Thank you for taking the time to fill out the questionnaire. It has been submitted.');
				} else {
					return redirect()
						->route('questionnaire_for_user.form.edit', $this->encryptData($serviceResponse->Data))
						->with('success', 'Your answers have been saved successfully.')
						->with('page', $restorePage)
						->with('restorePagination', $restorePagination)
						->with('restorepaginationPage', $restorepaginationPage);
					return redirect()->route('questionnaire_for_user.form.edit', $this->encryptData($serviceResponse->Data))->with('success', 'Your answers has been saved successfully.');
				}
				// echo $this->encryptData($serviceResponse->Data);
			} else {
				return Redirect::back()->with('error', 'Something Went Wrong');
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}

	public function GetAllSubmittedForm(Request $request)
	{
		try {
			$method = 'Method => ChildQuestionnaireController => GetAllSubmittedForm';
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/submitted/list';
			$response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			$response = json_decode($response);
			if ($response->Status == 200 && $response->Success) {
				$objData = json_decode($this->decryptData($response->Data));
				if ($objData->Code == 200) {
					$parant_data = json_decode(json_encode($objData->Data), true);
					$submitted_form =  $parant_data['submitted_form'];
					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
					return view('questionnaire_for_parents.submitted_index', compact('submitted_form', 'modules', 'screens'));
				}
			} else {
				$objData = json_decode($this->decryptData($response->Data));
				echo json_encode($objData->Code);
				exit;
			}
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}

	public function SubmittedForm($id)
	{ //echo $this->decryptData($id);exit;
		try {
		 $method = 'Method => ChildQuestionnaireController => SubmittedForm';
			// $gatewayURL = config('setting.api_gateway_url') . '/questionnaire/submitted/form/' . $id;
			// $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			// $response = json_decode($response); //dd($response);
			// if ($response->Status == 200 && $response->Success) {
			// 	$objData = json_decode($this->decryptData($response->Data));
			// 	if ($objData->Code == 200) {
			// 		$parant_data = json_decode(json_encode($objData->Data), true);
			// 		$question_details =  $parant_data['question_details'];
			// 		$questionDetails = $parant_data['questionDetails'];
			// 		$question = $parant_data['question'];
			// 		$role = $parant_data['role'];
			// 		$enrollmentDetails = $parant_data['enrollmentDetails'];
			// 		$fieldOptionsDB = $parant_data['fieldOptions'];
			// 		$fieldQuestionsDB = $parant_data['fieldQuestions'];
			// 		$questionnaire_initiation_id = $this->decryptData($id);
					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
					return view('questionnaire_for_child.submitted_form', compact('screens', 'modules'));
				// }
			// } else {
			// 	$objData = json_decode($this->decryptData($response->Data));
			// 	echo json_encode($objData->Code);
			// 	exit;
			// }
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}

	public function GraphGetdata(Request $request)
	{
		$method = 'Method => ChildQuestionnaireController => GraphGetdata';
		try {

			$serviceRequest = array();
			$serviceRequest['from'] = $request->from;
			$serviceRequest['to'] = $request->to;

			$request = array();
			$request['requestData'] = $this->encryptData($serviceRequest);

			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/graph/getdata';
			$serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

			$serviceResponse = json_decode($serviceResponse);
			if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
				$objData = json_decode($this->decryptData($serviceResponse->Data));
				if ($objData->Code == 200) {
					$rows = json_decode(json_encode($objData->Data), true);
					return $rows;
					echo json_encode($rows);
				}
			}
		} catch (\Exception $exc) {
			$exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $method;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
		}
	}

	public function sensoryreport($id)
	{ //echo $this->decryptData($id);exit;
		// dd($id);
		try {
			$method = 'Method => ChildQuestionnaireController => SubmittedForm';
			$gatewayURL = config('setting.api_gateway_url') . '/questionnaire/sensoryreport/' . $id;
			$response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
			$response = json_decode($response); //dd($response);
			if ($response->Status == 200 && $response->Success) {
				$objData = json_decode($this->decryptData($response->Data));
				if ($objData->Code == 200) {
					$parant_data = json_decode(json_encode($objData->Data), true);
					$questions = $parant_data['questions'];
					// dd($parant_data['questions']);

					$menus = $this->FillMenu();
					$screens = $menus['screens'];
					$modules = $menus['modules'];
					return view('questionnaire_for_parents.sensory_report', compact('questions', 'screens', 'modules'));
				}
			} else {
				$objData = json_decode($this->decryptData($response->Data));
				echo json_encode($objData->Code);
				exit;
			}
		} catch (\Exception $exc) {
			return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
		}
	}
}
