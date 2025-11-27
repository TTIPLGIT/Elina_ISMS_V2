<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Redirect;
use Illuminate\Http\Request;

class MasterQuestionCreationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $method = 'Method => MasterQuestionCreationController => index';
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/getdata';
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response = json_decode($response);
            // if ($response->Status == 200 && $response->Success) {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     if ($objData->Code == 200) {
            //         $parant_data = json_decode(json_encode($objData->Data), true);
            //         $questionnaire_index =  $parant_data['questionnaire_index'];
            //         $questionnaire_list =  $parant_data['questionnaire_list'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('13+QuestionCreation.index', compact('modules', 'screens'));
                // }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
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
            $method = 'Method => MasterQuestionCreationController => Create';
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/getdata';
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response = json_decode($response);
            // if ($response->Status == 200 && $response->Success) {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     if ($objData->Code == 200) {
            //         $parant_data = json_decode(json_encode($objData->Data), true);
            //         $questionnaire_index =  $parant_data['questionnaire_index'];
            //         $questionnaire_list =  $parant_data['questionnaire_list'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('13+QuestionCreation.create', compact('modules', 'screens'));
                // }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    // public function store_data(Request $request)
    // {
    //     try {
    //         $method = 'Method => MasterQuestionCreationController => store_data';
    //         $data = array();
    //         $data['questionnaire_id'] = $request->questionnaire_id;
    //         $data['discription'] = $request->discription;
    //         $data['no_of_ques'] = $request->no_of_ques;
    //         $encryptArray = $this->encryptData($data);
    //         $request = array();
    //         $request['requestData'] = $encryptArray;
    //         $gatewayURL = config('setting.api_gateway_url') . '/question_creation/storedata';
    //         $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
    //         $response1 = json_decode($response);
    //         if ($response1->Status == 200 && $response1->Success) {
    //             $objData = json_decode($this->decryptData($response1->Data));
    //             $data = json_decode(json_encode($objData->Data), true);
    //             $encryptData = $this->encryptData($data);
    //             echo $encryptData;
    //             // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
    //         } else {
    //             $objData = json_decode($this->decryptData($response1->Data));
    //             echo json_encode($objData->Code);
    //             exit;
    //         }
    //     } catch (\Exception $exc) {
            
    //         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    //     }
    // }

    public function add_questions($id)
    {
        try {
            $method = 'Method => MasterQuestionCreationController => add_questions';
           // $id = $this->decryptData($id); //dd($id);
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/data_edit/' . $this->encryptData($id);
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response1 = json_decode($response);
            // if ($response1->Status == 200) {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     $responseData = json_decode(json_encode($objData->Data), true);
            //     $questionnaire_list = $responseData['data']; //dd($questionnaire_list);
            //     $field_types = $responseData['field_types'];
            //     $question_details = $responseData['question_details'];
            //     $option_question_fields = $responseData['option_question_fields'];
            //     $sub_questions = $responseData['sub_questions'];
            //     $fields = $responseData['fields'];
            //     $options = $responseData['options'];
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('13+QuestionCreation.add_question', compact('modules', 'screens'));
            // } else {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
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
        // dd($request);
        try {
            $method = 'Method => MasterQuestionCreationController => store';

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
            // } else if ($field_type_id == 7 || $field_type_id == 6) {
            //     $data['sub_questions'] = $request->sub_question;
            //     $data['options'] = $request->sub_options;
            // }else if ($field_type_id == 8) {
            //     $data['options'] = "";
            //     $data['sub_questions'] = "";
            // } else if ($field_type_id == 9){
            //     $data['sub_questions'] = "";
            //     $data['options'] = "";
            //     $data['header_title'] = $request->header_title;
            //     $data['header_description'] = $request->header_description;
            // } else {
            //     $data['sub_questions'] = "";
            //     $data['options'] = "";
            // }
            // $data['quadrant_type_id'] = $request->quadrant_type_id;
            // $data['quadrant'] = $request->quadrant;

            $data = [
                'questionnaire_details_id' => $client_data,
                'field_type_id' => $request->field_type_id,
                'field_question' => $request->field_question,
                'question_field_name' => $clientdata,
                'question_description' => $request->question_description,
                'required' => $request->required,
                'options' => '',
                'sub_questions' => '',
                'header_title' => '',
                'header_description' => '',
                'quadrant_type_id' => $request->quadrant_type_id,
                'quadrant' => $request->quadrant,
                'other_option' => $request->other_option,
            ];
            if ($field_type_id == 3 || $field_type_id == 4 || $field_type_id == 5) {
                $data['options'] = $request->options_questions;
            } else if ($field_type_id == 7 || $field_type_id == 6) {
                $data['sub_questions'] = $request->sub_question;
                $data['options'] = $request->sub_options;
            } else if ($field_type_id == 9) {
                $data['header_title'] = $request->header_title;
                $data['header_description'] = $request->header_description;
            }
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/store_question';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('question_creation.add_questions', $this->encryptData($client_data));
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
            $method = 'Method => MasterQuestionCreationController => get_options';
            $data = array();
            // $data['edit_question_id'] = $request->edit_question_id;
            // $encryptArray = $this->encryptData($data);
            // $request = array();
            // $request['requestData'] = $encryptArray;
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/get_options';
            // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // $response1 = json_decode($response);
            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     $data = json_decode(json_encode($objData->Data), true);
            //     echo $data;
            //     // return redirect(route('question_creation.add_questions',$data))->with('success', 'Question Created Successfully');
            //  } 
            // else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
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
            $method = 'Method => MasterQuestionCreationController => show';
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
    public function edit($id)
    {
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
        // dd($request->edit_field_types_id);
        try {
            $method = 'Method => MasterQuestionCreationController => store';

            $edit_field_types_id = $request->edit_field_types_id;
            $client_data = $request->client_data;
            $data = array();
            $data['question_id'] = $this->decryptData($id);
            $data['field_type_id'] = $request->edit_field_types_id;
            $data['field_question'] = $request->edit_field_question;
            $data['sub_questions'] = $request->sub_questions;
            if ($edit_field_types_id == 7 || $edit_field_types_id == 6) {
                $data['options'] = $request->edit_sub_options;
            } else {
                $data['options'] = $request->options_question;
            }
            // dd($data);
            // $encryptArray = $this->encryptData($data);
            // $request = array();
            // $request['requestData'] = $encryptArray;
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/update_data';
            // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // $response1 = json_decode($response);
            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));

            //     if ($objData->Code == 200) {
            //         return redirect()->route('question_creation.add_questions', $this->encryptData($client_data));
            //     }

            //     if ($objData->Code == 400) {
            //         return Redirect::back()->with('fail', 'Metadata Client Field Name Already Exists');
            //     }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
            return redirect()->route('thirteenquestion_creation.add_questions', $this->encryptData($client_data));

        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function question_update(Request $request)
    {
        try {
            $method = 'Method => MasterQuestionCreationController => question_update';
            $data = array();
            // $data['questionnaire_details_id'] = $request->questionnaire_details_id;
            // $data['questionnaire_id'] = $request->questionnaire_id;
            // $data['discription'] = $request->discription;
            // $data['no_of_ques'] = $request->no_of_ques;
            // $encryptArray = $this->encryptData($data);
            // $request = array();
            // $request['requestData'] = $encryptArray;
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/question_update';
            // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // $response1 = json_decode($response);
            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     $data = json_decode(json_encode($objData->Data), true);
            //     $encryptData = $this->encryptData($data);
            //     echo $encryptData;
             return redirect(route('thirteenquestion_creation.add_questions',10))->with('success', 'Question Created Successfully');
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
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
            $method = 'Method => MasterQuestionCreationController => data_delete';
            //  $id = $this->decryptData($id);
            // $gatewayURL = config('setting.api_gateway_url') . '/question_creation/data_delete/' . $this->encryptData($id);
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response1 = json_decode($response);

            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     if ($objData->Code == 200) {
                    return redirect()->route('13+QuestionCreation.add_questions', 10);
                    return redirect(route('13+QuestionCreation.index'));
            //     }
            //     if ($objData->Code == 400) {
            //         return redirect(route('question_creation.index'))->with('fail', $objData->Code);
            //     }
            // }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => MasterQuestionCreationController => update_toggle';
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

            $method = 'Method => MasterQuestionCreationController => validationType';
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
