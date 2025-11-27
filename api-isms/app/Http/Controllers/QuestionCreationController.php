<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class QuestionCreationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        try {
            $method = 'Method => QuestionCreationController => get_data';
            // $this->WriteFileLog($method);
            $questionnaire_index = DB::select("SELECT a.questionnaire_description AS q_desc , a.* , b.* FROM questionnaire_details AS a INNER JOIN questionnaire AS b ON a.questionnaire_id = b.questionnaire_id
            WHERE b.active_flag=0");
            $questionnaire_list = DB::select("SELECT * FROM questionnaire 
            WHERE active_flag=0 AND questionnaire_id NOT IN (SELECT questionnaire_id FROM questionnaire_details WHERE active_flag = 1)");
            $response = [
                'questionnaire_index' => $questionnaire_index,
                'questionnaire_list' => $questionnaire_list
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $method = 'Method => QuestionCreationController => get_data';
            // $this->WriteFileLog($method);
            $rows = DB::select("SELECT * FROM questionnaire_details WHERE active_flag=0");
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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => storedata';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'discription' => $inputArray['discription'],
                'no_of_ques' => $inputArray['no_of_ques'],
            ];

            $question = DB::table('questionnaire_details')->insertGetId([
                'questionnaire_id' => $input['questionnaire_id'],
                'questionnaire_description' => $input['discription'],
                'no_questions' => $input['no_of_ques'],
                'active_flag' => 1,
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $question;
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

    public function data_edit($id)
    {

        $logMethod = 'Method => QuestionCreationController => data_edit';

        try {
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);
            $data = DB::select("select qd.questionnaire_description AS q_desc , qd.* , ques.* from questionnaire_details AS qd 
            INNER JOIN questionnaire AS ques ON ques.questionnaire_id=qd.questionnaire_id
            where qd.active_flag=1 and questionnaire_details_id=$id");
            $field_types = DB::Select("select * from questionnaire_field_types where active_flag=1");
            $question_details = DB::select("select * from question_details where active_flag=1 and questionnaire_details_id=$id ORDER BY question_order ASC ");
            $option_question_fields = DB::Select("select * from option_question_fields where active_flag=1");
            $sub_questions = DB::Select("select * from sub_questions where active_flag=1");

            $questionnaire_id = $data[0]->questionnaire_id;
            $fields = DB::table('questionnaire_quadrant_category')
                ->select('*')
                ->where('questionnaire_id', $questionnaire_id)
                ->get();

            $options = DB::table('quadrant_questionnaire')
                ->select('*')
                ->where('questionnaire_id', $questionnaire_id)
                ->get();

            $response = [
                'data' => $data,
                'field_types' => $field_types,
                'question_details' => $question_details,
                'option_question_fields' => $option_question_fields,
                'sub_questions' => $sub_questions,
                'fields' => $fields,
                'options' => $options,
            ];
            // $this->WriteFileLog($data);
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

    public function store_question(Request $request)
    {
        $logMethod = 'Method => QuestionCreationController => store_question';

        try {
            $inputArray = $this->DecryptData($request->requestData);

            $input = [
                'field_type_id' => $inputArray['field_type_id'],
                'field_question' => $inputArray['field_question'],
                'question_field_name' => $inputArray['question_field_name'],
                'questionnaire_details_id' => $inputArray['questionnaire_details_id'],
                'quadrant_type_id' => $inputArray['quadrant_type_id'],
                'quadrant' => $inputArray['quadrant'],
                'header_title' => $inputArray['header_title'],
                'header_description' => $inputArray['header_description'],
                'question_description' => $inputArray['question_description'],
                'required' => $inputArray['required'] ?? 0,
                'other_option' => $inputArray['other_option'] ?? 0,
            ];

            // Ensure options and sub_questions are arrays
            $input['options'] = $inputArray['options'] ?? [];
            if (is_string($input['options'])) {
                $decoded = json_decode($input['options'], true);
                $input['options'] = is_array($decoded) ? $decoded : [];
            }

            $input['sub_questions'] = $inputArray['sub_questions'] ?? [];
            if (is_string($input['sub_questions'])) {
                $decoded = json_decode($input['sub_questions'], true);
                $input['sub_questions'] = is_array($decoded) ? $decoded : [];
            }


            $type_id = $input['field_type_id'];
            $metadata_client_field_name = $input['question_field_name'];
            $questionnaire_details_id = $input['questionnaire_details_id'];

            // Get last question details for this questionnaire
            $question_details = DB::select("
            SELECT * FROM question_details
            WHERE questionnaire_details_id = ?
            ORDER BY question_field_name DESC
            LIMIT 1
        ", [$questionnaire_details_id]);

            if (empty($question_details)) {
                $metadata_client_field_name .= '_001';
                $question_order = 1;
            } else {
                $last_question = $question_details[0];
                $ww = $last_question->question_field_name;

                if (empty($ww)) {
                    $metadata_client_field_name .= '_001';
                } else {
                    $metadata_client_field_name = $input['question_field_name'] . '_' . str_pad($last_question->question_order + 1, 3, '0', STR_PAD_LEFT);
                }

                $question_order = $last_question->question_order + 1;
            }

            // Get related table name
            $table = DB::select("
            SELECT b.table_name
            FROM questionnaire_details AS a
            INNER JOIN questionnaire AS b ON b.questionnaire_id = a.questionnaire_id
            WHERE a.questionnaire_details_id = ?
        ", [$questionnaire_details_id]);

            $table_name = $table[0]->table_name ?? 'question_process';

            // Determine column type for this question
            $column_type = match ($type_id) {
                1, 2, 5, 8 => "TEXT",
                3, 4 => "VARCHAR(250)",
                6, 7 => "VARCHAR(100)",
                10, 11 => "VARCHAR(25)",
                default => null,
            };

            // Check for duplicate field name
            $datachecking = DB::select("
            SELECT * FROM question_details WHERE question_field_name = ?
        ", [$metadata_client_field_name]);

            if (!empty($datachecking)) {
                // Field name already exists
                $serviceResponse = [
                    'Code' => 400,
                    'Message' => 'Question already exists',
                    'Data' => 1,
                ];
                return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), 400, true);
            }

            // ============================
            // MAIN INSERT TRANSACTION
            // ============================
            $question_details_id = null;

            if ($type_id == 9) {
                // Header-type question (no field addition)
                DB::transaction(function () use ($input, $question_order, &$question_details_id) {
                    $question_details_id = DB::table('question_details')->insertGetId([
                        'questionnaire_details_id' => $input['questionnaire_details_id'],
                        'questionnaire_field_types_id' => $input['field_type_id'],
                        'question' => $input['header_title'],
                        'question_field_name' => '',
                        'created_by' => auth()->user()->id,
                        'created_date' => now(),
                        'required' => 0,
                        'question_description' => $input['header_description'],
                        'question_order' => $question_order,
                    ]);
                });
            } else {
                DB::transaction(function () use ($input, $metadata_client_field_name, $question_order, &$question_details_id) {
                    $question_details_id = DB::table('question_details')->insertGetId([
                        'questionnaire_details_id' => $input['questionnaire_details_id'],
                        'questionnaire_field_types_id' => $input['field_type_id'],
                        'question' => $input['field_question'],
                        'question_field_name' => $metadata_client_field_name,
                        'created_by' => auth()->user()->id,
                        'created_date' => now(),
                        'quadrant' => $input['quadrant'],
                        'quadrant_type' => $input['quadrant_type_id'],
                        'required' => ($input['required'] == 1 ? 1 : 0),
                        'question_description' => $input['question_description'],
                        'question_order' => $question_order,
                        'other_option' => ($input['other_option'] == 1 ? 1 : 0),
                    ]);

                    // Insert options
                    foreach ($input['options'] as $option) {
                        DB::table('option_question_fields')->insert([
                            'question_details_id' => $question_details_id,
                            'option_for_question' => $option,
                            'active_flag' => 1,
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                        ]);
                    }

                    // Insert sub questions
                    foreach ($input['sub_questions'] as $sub_question) {
                        DB::table('sub_questions')->insert([
                            'question_details_id' => $question_details_id,
                            'sub_question' => $sub_question,
                            'active_flag' => 1,
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                        ]);
                    }

                    // Update question count
                    $count_question = DB::table('question_details')
                        ->where('active_flag', 1)
                        ->where('questionnaire_details_id', $input['questionnaire_details_id'])
                        ->count();

                    DB::table('questionnaire_details')
                        ->where('questionnaire_details_id', $input['questionnaire_details_id'])
                        ->update(['question_count' => $count_question]);
                });
            }

            // ============================
            // SCHEMA ALTER (OUTSIDE TRANSACTION)
            // ============================
            if ($type_id != 9 && $column_type) {
                if (!empty($input['sub_questions'])) {
                    foreach ($input['sub_questions'] as $index => $sub_question) {
                        $column_name = $metadata_client_field_name . '_sub' . ($index + 1);
                        DB::unprepared("ALTER TABLE {$table_name} ADD {$column_name} {$column_type}");
                    }
                } else {
                    DB::unprepared("ALTER TABLE {$table_name} ADD {$metadata_client_field_name} {$column_type}");
                }
            }

            // ============================
            // SUCCESS RESPONSE
            // ============================
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            // Error handling
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

    // public function store_question(Request $request)
    // {
    //     $logMethod = 'Method => QuestionCreationController => store_question';
    //     try {
    //         $inputArray = $this->DecryptData($request->requestData);

    //         $input = [
    //             'field_type_id' => $inputArray['field_type_id'],
    //             'field_question' => $inputArray['field_question'],
    //             'question_field_name' => $inputArray['question_field_name'],
    //             'questionnaire_details_id' => $inputArray['questionnaire_details_id'],
    //             'options' => $inputArray['options'],
    //             'sub_questions' => $inputArray['sub_questions'],
    //             'quadrant_type_id' => $inputArray['quadrant_type_id'],
    //             'quadrant' => $inputArray['quadrant'],
    //             'header_title' => $inputArray['header_title'],
    //             'header_description' => $inputArray['header_description'],
    //             'question_description' => $inputArray['question_description'],
    //             'required' => $inputArray['required'],
    //             'other_option' => $inputArray['other_option'],
    //         ];

    //         $type_id = $inputArray['field_type_id'];

    //         $metadata_client_field_name = $input['question_field_name'];

    //         $option = $input['options'];
    //         $questionnaire_details_id = $input['questionnaire_details_id'];
    //         $question_details = DB::select("select * from question_details WHERE questionnaire_details_id=$questionnaire_details_id ORDER BY question_field_name DESC ");
    //         if ($question_details == null) {
    //             $metadata_client_field_name =  $input['question_field_name'] . '_001';
    //             $question_order = 1;
    //         } else {
    //             $ww = $question_details[0]->question_field_name;
    //             if ($ww == null || !empty($ww)) {
    //                 $metadata_client_field_name =  $input['question_field_name'] . '_001';
    //             } else {
    //                 $metadata_client_field_name =  ++$ww;
    //             }
    //             $ww2 = $question_details[0]->question_order;
    //             $question_order = $ww2 + 1;
    //         }
    //         $table = DB::select("SELECT b.* FROM questionnaire_details AS a INNER JOIN questionnaire AS b ON b.questionnaire_id = a.questionnaire_id
    //         WHERE questionnaire_details_id = $questionnaire_details_id");
    //         $table_name = $table[0]->table_name;
    //         if ($table_name == '') {
    //             $table_name = 'question_process';
    //         }
    //         if ($type_id == 1 || $type_id == 2 || $type_id == 8 || $type_id == 5) {
    //             $column_type = "ALTER TABLE " . $table_name . " ADD " . $metadata_client_field_name . " text ";
    //         } elseif ($type_id == 3 || $type_id == 4) {
    //             $column_type = "ALTER TABLE " . $table_name . " ADD " . $metadata_client_field_name . " varchar(250) ";
    //         } elseif ($type_id == 6 || $type_id == 7) {
    //             $column_type = "ALTER TABLE " . $table_name . " ADD " . $metadata_client_field_name . " varchar(100) ";
    //         } elseif ($type_id == 10 || $type_id == 11) {
    //             $column_type = "ALTER TABLE " . $table_name . " ADD " . $metadata_client_field_name . " varchar(25) ";
    //         }

    //         $datachecking = DB::select("select lpad.* from question_details as lpad where lpad.question_field_name = '$metadata_client_field_name' ");

    //         if ($datachecking == []) {
    //             if ($type_id == 9) {
    //                 DB::transaction(function () use ($input, $question_order) {
    //                     $question_details_id = DB::table('question_details')->insertGetId([
    //                         'questionnaire_details_id' => $input['questionnaire_details_id'],
    //                         'questionnaire_field_types_id' => $input['field_type_id'],
    //                         'question' => $input['header_title'],
    //                         'question_field_name' => '',
    //                         'created_by' => auth()->user()->id,
    //                         'created_date' => NOW(),
    //                         'required' => '0',
    //                         'question_description' => $input['header_description'],
    //                         'question_order' => $question_order,
    //                     ]);
    //                 });
    //             } else {
    //                 DB::transaction(function () use ($input, $metadata_client_field_name, $column_type, $table_name, $question_order) {

    //                     $question_details_id = DB::table('question_details')->insertGetId([
    //                         'questionnaire_details_id' => $input['questionnaire_details_id'],
    //                         'questionnaire_field_types_id' => $input['field_type_id'],
    //                         'question' => $input['field_question'],
    //                         'question_field_name' => $metadata_client_field_name,
    //                         'created_by' => auth()->user()->id,
    //                         'created_date' => NOW(),
    //                         'quadrant' => $input['quadrant'],
    //                         'quadrant_type' => $input['quadrant_type_id'],
    //                         'required' => ($input['required'] == 1 ? 1 : 0),
    //                         'question_description' => $input['question_description'],
    //                         'question_order' => $question_order,
    //                         'other_option' => ($input['other_option'] == 1 ? 1 : 0),
    //                     ]);

    //                     $option = $input['options'];
    //                     if (!empty($option)) {
    //                         $optioncount = count($option);
    //                         for ($i = 0; $i < $optioncount; $i++) {
    //                             DB::table('option_question_fields')->insertGetId([
    //                                 'question_details_id' => $question_details_id,
    //                                 'option_for_question' => $option[$i],
    //                                 'active_flag' => '1',
    //                                 'created_by' => auth()->user()->id,
    //                                 'created_date' => NOW()
    //                             ]);
    //                         }
    //                     }

    //                     $sub_questions = $input['sub_questions'];
    //                     if (!empty($sub_questions)) {
    //                         $question_count = count($sub_questions);
    //                         for ($i = 0; $i < $question_count; $i++) {

    //                             $eee1 = DB::table('sub_questions')->insertGetId([
    //                                 'question_details_id' => $question_details_id,
    //                                 'sub_question' => $sub_questions[$i],
    //                                 'active_flag' => '1',
    //                                 'created_by' => auth()->user()->id,
    //                                 'created_date' => NOW()
    //                             ]);

    //                             $eee2 = $metadata_client_field_name . $eee1;
    //                             $ew2 = DB::unprepared("ALTER TABLE " . $table_name . " ADD " . $eee2 . " varchar(255) ");
    //                         }
    //                     } else {
    //                         $ew1 = DB::unprepared($column_type);
    //                     }

    //                     $questionnaire_details_id = $input['questionnaire_details_id'];
    //                     $question_detail = DB::select("SELECT * FROM question_details WHERE active_flag=1 and questionnaire_details_id=$questionnaire_details_id");
    //                     $count_question = count($question_detail);
    //                     DB::table('questionnaire_details')
    //                         ->where('questionnaire_details_id', $questionnaire_details_id)
    //                         ->update([
    //                             'question_count' => $count_question
    //                         ]);
    //                 });
    //             }

    //             $serviceResponse = array();
    //             $serviceResponse['Code'] = config('setting.status_code.success');
    //             $serviceResponse['Message'] = config('setting.status_message.success');
    //             $serviceResponse['Data'] = 1;
    //             $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //             $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //             return $sendServiceResponse;
    //         } else {

    //             $serviceResponse = array();
    //             $serviceResponse['Code'] = 400;
    //             $serviceResponse['Message'] = config('setting.status_message.success');
    //             $serviceResponse['Data'] = 1;
    //             $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //             $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //             return $sendServiceResponse;
    //         }
    //     } catch (\Exception $exc) {
    //         $exceptionResponse = array();
    //         $exceptionResponse['ServiceMethod'] = $logMethod;
    //         $exceptionResponse['Exception'] = $exc->getMessage();
    //         $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
    //         $this->WriteFileLog($exceptionResponse);
    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.exception');
    //         $serviceResponse['Message'] = $exc->getMessage();
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
    //         return $sendServiceResponse;
    //     }
    // }

    public function get_options(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => get_options';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'edit_question_id' => $inputArray['edit_question_id'],
            ];
            $id = $input['edit_question_id'];
            $row = DB::select("SELECT questionnaire_field_types_id from question_details WHERE question_details_id=$id");
            $row1 = $row[0]->questionnaire_field_types_id;
            // $this->WriteFileLog($row1);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row1;
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

    public function update_data(Request $request)
    {
        $logMethod = 'Method => DocumentProcessReportController => update_data';
        try {
            $inputArray = $this->DecryptData($request->requestData);

            $userID = auth()->user()->id;
            $input = [
                'question_id' => $inputArray['question_id'],
                'field_type_id' => $inputArray['field_type_id'],
                'field_question' => $inputArray['field_question'],
                'sub_questions' => $inputArray['sub_questions'],
                'options' => $inputArray['options']
            ];
            // $this->WriteFileLog($input);
            $id = $input['question_id'];
            $sub_questions = $input['sub_questions'];
            $option = $input['options'];

            DB::transaction(function () use ($input, $id, $sub_questions, $option) {

                DB::table('question_details')
                    ->where('question_details_id', $id)
                    ->update([
                        'question' => $input['field_question'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => now()
                    ]);

                $delete_option  = DB::table('option_question_fields')->where('question_details_id', $id)->delete();

                if ($sub_questions != []) {

                    $delete = DB::select("SELECT * FROM question_details AS qd
                    INNER JOIN sub_questions AS sq ON sq.question_details_id=qd.question_details_id
                    WHERE sq.question_details_id=$id");
                    $delCount = count($delete);

                    // $this->WriteFileLog($delete);

                    for ($j = 0; $j < $delCount; $j++) {
                        $a = $delete[$j]->question_field_name;
                        $b = $delete[$j]->sub_questions_id;
                        $ew2 = $a . $b;
                        // $ew1 = DB::unprepared("ALTER TABLE question_process DROP COLUMN " . $ew2);
                    }

                    $delete_sub_question  = DB::table('sub_questions')->where('question_details_id', $id)->delete();

                    $question_count = count($sub_questions);
                    for ($i = 0; $i < $question_count; $i++) {
                        $cre = DB::table('sub_questions')->insertGetId([
                            'question_details_id' => $id,
                            'sub_question' => $sub_questions[$i],
                            'active_flag' => '1',
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);

                        $delete = DB::select("SELECT * FROM question_details WHERE question_details_id=$id");
                        $client_field_name = $delete[0]->question_field_name;
                        $eee2 = $client_field_name . $cre;
                        // $ew3 = DB::unprepared("ALTER TABLE question_process ADD " . $eee2 . " varchar(255) ");
                    }
                }

                if ($option != []) {
                    $optioncount = count($option);
                    for ($i = 0; $i < $optioncount; $i++) {
                        DB::table('option_question_fields')->insertGetId([
                            'question_details_id' => $id,
                            'option_for_question' => $option[$i],
                            'active_flag' => '1',
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);
                    }
                }
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

    public function question_delete($id)
    {
        try {
            $method = 'Method =>NewenrollementController => question_delete';
            $id = $this->decryptData($id);
            $check = DB::select("select * from questionnaire_details where questionnaire_details_id = '$id' and active_flag = '1' ");

            if ($check != []) {

                DB::table('questionnaire_details')
                    ->where('questionnaire_details_id', $id)
                    ->update([
                        'active_flag' => 0,
                    ]);

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
    }

    public function question_update(Request $request)
    {
        try {
            $method = 'Method => QuestionCreationController => question_update';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'questionnaire_details_id' => $inputArray['questionnaire_details_id'],
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'discription' => $inputArray['discription'],
                'no_of_ques' => $inputArray['no_of_ques'],
            ];

            $id = $input['questionnaire_details_id'];
            DB::table('questionnaire_details')
                ->where('questionnaire_details_id', $id)
                ->update([
                    'questionnaire_id' => $input['questionnaire_id'],
                    'questionnaire_description' => $input['discription'],
                    'no_questions' => $input['no_of_ques'],
                ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $id;
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
        try {
            $method = 'Method =>QuestionCreationController => data_delete';
            $id = $this->decryptData($id);
            $check = DB::select("select * from question_details where question_details_id = '$id' and active_flag = '1' ");
            $questionnaire_details_id = $check[0]->questionnaire_details_id;
            if ($check != []) {

                DB::table('question_details')
                    ->where('question_details_id', $id)
                    ->update([
                        'active_flag' => 0,
                    ]);


                $question_detail = DB::select("SELECT * FROM question_details WHERE active_flag=1 and questionnaire_details_id=$questionnaire_details_id");
                $count_question = count($question_detail);
                DB::table('questionnaire_details')
                    ->where('questionnaire_details_id', $questionnaire_details_id)
                    ->update([
                        'question_count' => $count_question
                    ]);

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $questionnaire_details_id;
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

    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => update_toggle';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'is_active' => $inputArray['is_active'],
                'f_id' => $inputArray['f_id'],
            ];
            // $this->WriteFileLog($input);

            DB::table('question_details')
                ->where('question_details_id', $input['f_id'])
                ->update([
                    'enable_flag' => $input['is_active'],
                ]);


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

    public function viewdata($id)
    {

        $logMethod = 'Method => QuestionCreationController => viewdata';

        try {
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);

            $question = DB::select("SELECT qd.question , qd.question_field_name , qft.questionnaire_field_types_id, qd.question_details_id FROM question_details AS qd 
            INNER JOIN questionnaire_field_types AS qft ON qft.questionnaire_field_types_id=qd.questionnaire_field_types_id
            INNER JOIN questionnaire_details AS que ON que.questionnaire_details_id=qd.questionnaire_details_id
            WHERE qd.active_flag=1 AND qd.enable_flag=1 AND que.questionnaire_details_id=$id");

            $questionnaire = DB::select("SELECT Q.questionnaire_name FROM questionnaire_details AS qd
            INNER JOIN questionnaire AS Q ON Q.questionnaire_id=qd.questionnaire_id
            WHERE questionnaire_details_id=$id");

            $questionnaire_name = $questionnaire[0]->questionnaire_name;
            $response = [
                'question' => $question,
                'questionnaire_name' => $questionnaire_name
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

    public function validation_type(Request $request)
    {
        try {

            $method = 'Method => QuestionCreationController => validation_type';
            $inputArray = $this->decryptData($request->requestData);
            $validation_type = $inputArray['validation_type'];

            $data = DB::select("select * from form_validation where active_flag = 0 and type = $validation_type");


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $data;
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
