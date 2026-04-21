<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Redirect;
use Illuminate\Http\Request;

class QuestionCreationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/getdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $questionnaire_index =  $parant_data['questionnaire_index'];
                    $questionnaire_list =  $parant_data['questionnaire_list'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('QuestionCreation.index', compact('questionnaire_index', 'modules', 'screens'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $method = 'Method => QuestionCreationController => Create';
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/getdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $questionnaire_index =  $parant_data['questionnaire_index'];
                    $questionnaire_list =  $parant_data['questionnaire_list'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('QuestionCreation.create', compact('questionnaire_list', 'modules', 'screens'));
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

    public function store_data(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => store_data';
            $data = array();
            $data['questionnaire_id'] = $request->questionnaire_id;
            $data['discription'] = $request->discription;
            $data['no_of_ques'] = $request->no_of_ques;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                echo $encryptData;
                // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function add_questions($id)
    {
        try {
            $method = 'Method => QuestionCreationController => add_questions';

            $id = $this->decryptData($id);

            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/data_edit/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200) {

                $objData = json_decode($this->decryptData($response1->Data));
                $responseData = json_decode(json_encode($objData->Data), true);

                $questionnaire_list = $responseData['data'];
                $field_types = $responseData['field_types'];
                $question_details = $responseData['question_details'];
                $option_question_fields = $responseData['option_question_fields'];
                $sub_questions = $responseData['sub_questions'];
                $fields = $responseData['fields'];
                $options = $responseData['options'];

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                $routeName = request()->route()->getName();

                // dd($field_types);
                $view = ($routeName == 'question_creation.view_questions') ? 'QuestionCreation.view_question' : 'QuestionCreation.add_question';

                return view($view, compact('modules', 'screens', 'questionnaire_list', 'field_types', 'question_details', 'sub_questions', 'option_question_fields', 'fields', 'options'));
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog(
                $method,
                $exc->getCode(),
                $exc->getMessage(),
                $exc->getLine(),
                $exc->getTrace()[0]['args'][2]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $method = 'Method => QuestionCreationController => store';

            // $client_data = $request->metadata_client_field_name;
            // $clientdata = str_replace(' ', '_', $client_data);//questionnaire_details_id
            $client_data = $request->client_data;
            $clientdata = 'Question_' . $client_data;
            $field_type_id = $request->field_type_id;

            // $data = array();
            // $data['questionnaire_details_id'] = $client_data;
            // $data['field_type_id'] = $request->field_type_id;
            // $data['field_question'] = $request->field_question;
            // $data['question_field_name'] = $clientdata;
            // $data['header_title'] = "";
            // $data['header_description'] = "";
            // $data['question_description'] = $request->question_description;
            // $data['required'] = $request->required;
            // if ($field_type_id == 3 || $field_type_id == 4 || $field_type_id == 5) {
            //     $data['options'] = $request->options_questions;
            //     $data['sub_questions'] = "";
            // $data['quadrant'] = $request->quadrant;

            $f_que = $request->field_question;
            $desc = $request->add_question_description ?? $request->question_description ?? $request->description ?? '';
            
            $data = [
                'questionnaire_details_id' => $client_data,
                'field_type_id' => $request->field_type_id,
                'field_question' => $f_que,
                'question' => $f_que,
                'header_title' => $f_que,
                'title' => $f_que,
                'question_field_name' => $clientdata,
                'question_description' => $desc,
                'header_description' => $desc,
                'description' => $desc,
                'discription' => $desc,
                'required' => $request->required,
                'options' => '',
                'sub_questions' => '',
                'quadrant_type_id' => $request->quadrant_type_id,
                'quadrant' => $request->quadrant,
                'other_option_enabled' => $request->other_option_enabled ?? 0,
            ];

            if ($field_type_id == 3 || $field_type_id == 4 || $field_type_id == 5) {
                $data['options'] = $request->options_questions ?? '';
            } else if ($field_type_id == 7 || $field_type_id == 6 || $field_type_id == 12) {
                $data['sub_questions'] = $request->sub_questions ?? '';
                $data['options'] = $request->options_questions ?? '';
            }
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/store_question';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // dd($response1);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('question_creation.add_questions', $this->encryptData($client_data))->with('success', 'Submitted successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Metadata Client Field Name Already Exists');
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

    public function get_options(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => get_options';
            $data = array();
            $data['edit_question_id'] = $request->edit_question_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/get_options';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                echo $data;
                // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { //echo $this->decryptData($id);exit;
        try {
            // dd($this->decryptData($id));
            $method = 'Method => QuestionCreationController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/viewdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $question =  $parant_data['question'];
                    $questionnaire_name = $parant_data['questionnaire_name'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('QuestionCreation.view', compact('questionnaire_name', 'screens', 'modules', 'question'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->edit_field_types_id);
        try {
            $method = 'Method => QuestionCreationController => update';

            $edit_field_types_id = $request->edit_field_types_id;
            $client_data = $request->client_data;

            // Deep fallback extraction
            $f_que = $request->input('field_question') ?? $request->input('edit_field_question') ?? $request->input('question') ?? $request->field_question ?? $request->header_title ?? '';
            $desc = $request->input('question_description') ?? $request->input('description') ?? $request->input('edit_question_description') ?? $request->question_description ?? $request->header_description ?? $request->discription ?? '';
            
            $data = [
                'question_id' => $this->decryptData($id),
                'id' => $this->decryptData($id),
                'question_details_id' => $this->decryptData($id),
                'q_id' => $this->decryptData($id),
                'questionnaire_details_id' => $client_data,
                'field_type_id' => $edit_field_types_id,
                
                // Titles
                'field_question' => $f_que,
                'question' => $f_que,
                'header_title' => $f_que,
                'title' => $f_que,
                
                // Descriptions
                'question_description' => $desc,
                'header_description' => $desc,
                'description' => $desc,
                'discription' => $desc,
                'field_description' => $desc,
                'q_desc' => $desc,
                'q_description' => $desc,
                'item_description' => $desc,
                'details_description' => $desc,
                
                'question_field_name' => $request->question_field_name,
                'required' => 1,
                'options' => [],
                'sub_questions' => [],
                'quadrant_type_id' => $request->quadrant_type_id,
                'quadrant' => $request->quadrant,
                'other_option_enabled' => $request->other_option_enabled ?? 0,
            ];

            if ($edit_field_types_id == 8) {
                $data['quadrant_type'] = $request->quadrant_type_id; 
                $data['category'] = $request->quadrant_type_id;
            } else if ($edit_field_types_id == 7 || $edit_field_types_id == 6 || $edit_field_types_id == 12) {
                $data['sub_questions'] = $request->sub_questions ?? [];
                $data['options'] = $request->edit_sub_options ?? $request->options_questions ?? [];
            } else if ($edit_field_types_id == 3 || $edit_field_types_id == 4 || $edit_field_types_id == 5) {
                $data['options'] = $request->options_questions ?? $request->options_question ?? [];
            }
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/update_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('question_creation.add_questions', $this->encryptData($client_data))->with('success', 'Updated successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Metadata Client Field Name Already Exists');
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

    public function question_update(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => question_update';
            $data = array();
            $data['questionnaire_details_id'] = $request->questionnaire_details_id;
            $data['questionnaire_id'] = $request->questionnaire_id;
            $desc = $request->discription ?? $request->description ?? '';
            $data['discription'] = $desc;
            $data['description'] = $desc;
            $data['questionnaire_description'] = $desc;
            $data['no_of_ques'] = $request->no_of_ques;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/question_update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                echo $encryptData;
                // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        try {
            $method = 'Method => NewenrollementController => destroy';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/question_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('question_creation.index'));
                }
                if ($objData->Code == 400) {
                    return redirect(route('question_creation.index'))->with('fail', $objData->Code);
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function data_delete($id)
    {
        try {
            $method = 'Method => QuestionCreationController => data_delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect()
                        ->route('question_creation.add_questions', $this->encryptData($objData->Data))
                        ->with('success', 'Question deleted successfully');
                    return redirect(route('question_creation.index'));
                }
                if ($objData->Code == 400) {
                    return redirect(route('question_creation.index'))->with('fail', $objData->Code);
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => update_toggle';
            $data = array();
            $data['is_active'] = $request->is_active;
            $data['f_id'] = $request->f_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire/update_toggle';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                echo $this->decryptData($response1->Data);
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function validationType(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => validationType';
            $data = array();
            $data['validation_type'] = $request->validation_type;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire/validation/type';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                return $data;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
