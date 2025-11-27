<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BusinessCategoryMasterAPIController extends BaseController
{
    public function index(Request $request)
    {
        $method = 'Method => BusinessCategoryMasterAPIController => index';
        try {
            $rows = DB::select("SELECT id, school_name, school_unique FROM schools_registration");

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
    public function create(Request $request)
    {
        try {
            $method = 'Method => BusinessCategoryMasterAPIController => createdata';


            $rows = DB::select("select * from school_enrollment_details");


            $response = [

                'rows' =>  $rows,

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
            $method = 'Method => BusinessCategoryMasterAPIController => storedata';
            $inputData = $this->decryptData($request->requestData);

            $schoolId = DB::transaction(function () use ($inputData) {

                $claimdetails = DB::table('schools_registration')->orderBy('id', 'desc')->first();

                if ($claimdetails == null) {
                    $schoolUnique = 'SCL/REG/' . date("Y") . '/' . date("m") . '/001';
                } else {
                    $enrollmentchildnum = $claimdetails->school_unique;
                    $numberPart = substr($enrollmentchildnum, -3);
                    $newNumber = str_pad($numberPart + 1, 3, '0', STR_PAD_LEFT);
                    $schoolUnique = 'SCL/REG/' . date("Y") . '/' . date("m") . '/' . $newNumber;
                }

                $schoolId = DB::table('schools_registration')->insertGetId([
                    'school_unique' => $schoolUnique,
                    'school_name' => $inputData['schoolName'],
                    'school_type' => $inputData['schoolType'],
                    'school_address' => $inputData['schoolAddress'],
                    'contact_name' => $inputData['contactName'],
                    'contact_position' => $inputData['contactPosition'],
                    'contact_phone' => $inputData['contactPhone'],
                    'contact_email' => $inputData['contactEmail'],
                    'website' => $inputData['website'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $data = [
                    'affiliate_reference_id' => $schoolId,
                    'affiliate_reference_table' => 'schools_registration',
                    'affiliation_type_id' => 1,
                    'affiliation_start_date' => '2025-01-01',
                    'affiliation_end_date' => null,
                    'affiliation_details' => 'Affiliated with the National Education Program',
                ];
                
                $this->AffiliationsDetails($data);

                return $schoolId;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $schoolId;
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

    public function AffiliationsDetails($data){
        $affiliationId = DB::table('affiliations_details')->insertGetId($data);
    }

    public function getdata(Request $request)
    {
        $method = 'Method => BusinessCategoryMasterAPIController => getdata';
        try {
            
            $id = $this->DecryptData($request[0]);
            $rows = DB::select("SELECT * FROM schools_registration where id = $id");

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
            $method = 'Method => BusinessCategoryMasterAPIController => updatedata';
            $inputData = $this->decryptData($request->requestData);

            $schoolId = DB::transaction(function () use ($inputData) {

                DB::table('schools_registration')
                ->where('id', $inputData['id'])
                ->update([
                    'school_name' => $inputData['schoolName'],
                    'school_type' => $inputData['schoolType'],
                    'school_address' => $inputData['schoolAddress'],
                    'contact_name' => $inputData['contactName'],
                    'contact_position' => $inputData['contactPosition'],
                    'contact_phone' => $inputData['contactPhone'],
                    'contact_email' => $inputData['contactEmail'],
                    'website' => $inputData['website'] ?? null,
                    'updated_at' => now(),
                ]);

                return $inputData['id'];
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $schoolId;
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
