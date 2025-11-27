<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataMigrationController extends BaseController
{

    public function data_migration(Request $request)
    {
        try {
            $method = 'Method => DataMigrationController => index';

            $token = 'mnbvcxzasfghjkl';
            if ($request->token == $token) {
                // Specify the path to your Excel file
                $excelFilePath = storage_path('app/public/Data_Migration/data_migration.xlsx'); // Change this to your file path

                // Load the Excel file
                $spreadsheet = IOFactory::load($excelFilePath);

                // Select the first worksheet
                $worksheet = $spreadsheet->getActiveSheet();

                // Get the highest row number and column letter
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                // Convert the column letter to a numeric index
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

                // Initialize an array to store the data
                $data = [];

                // Loop through each row and column to retrieve data
                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = [];
                    for ($col = 1; $col <= $highestColumnIndex; $col++) {
                        $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                        $rowData[] = $cellValue;
                    }
                    $data[] = $rowData;
                }

                $password = 'Login@123';
                DB::beginTransaction();
                    for ($i = 1; $i < count($data); $i++) {
                        // Created at formatting
                        $dateString = $data[$i][10];
                        $dateTime = \DateTime::createFromFormat('d-m-Y', $dateString);
                        $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
                        $OVM_date = $dateTime->format('d/m/Y');
                        $OVM_time = $dateTime->format('H:i:s');

                        $formattedYear = $dateTime->format('Y');
                        $formattedMonth = $dateTime->format('m');

                        // User Details
                        $user_id = DB::table('users')
                            ->insertGetId([
                                'name' => $data[$i][1],
                                'user_type' => 'MA',
                                'email' => $data[$i][2],
                                'password' => bcrypt($password),
                                'array_roles' => '3',
                                'designation_id' => '2',
                                'created_at' => $formattedDateTime,

                            ]);
                        // DOB formatting
                        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[1][3]);
                        $formattedDate_DOB = $date->format('d-m-y'); // Adjust the format as needed

                        // services_from_elina
                        $inputString = $data[$i][11];
                        $valuesArray = explode(',', $inputString);
                        $resultArray = array_combine(range(0, count($valuesArray) - 1), $valuesArray);
                        $services_from_elina = array_map(function ($key) {
                            return (string) $key;
                        }, $resultArray);

                        $services_from_elina = json_encode($resultArray, JSON_FORCE_OBJECT);

                        // how_knowabt_elina

                        $inputString2 = $data[$i][12];
                        $valuesArray2 = explode(',', $inputString2);
                        $resultArray2 = array_combine(range(0, count($valuesArray2) - 1), $valuesArray2);
                        $resultArray2 = array_map(function ($key) {
                            return (string) $key;
                        }, $resultArray2);

                        $how_knowabt_elina = json_encode($resultArray2, JSON_FORCE_OBJECT);

                        // Enrollment & child number generation
                        $Enrollmentdetails = DB::table('enrollment_details as ed')
                            ->join('users as us', 'us.id', '=', 'ed.user_id')
                            ->where('us.user_type', '=', 'MA')
                            ->orderBy('ed.enrollment_id', 'desc')
                            ->first();
                        if ($Enrollmentdetails == null) {
                            $childnoNew = 'CH/' . $formattedYear . '/001M';
                            $enrollmentnum = 'EN/' . $formattedYear . '/' . $formattedMonth . '/001M';

                        } else {
                            $lastThreeDigits = intval(substr($Enrollmentdetails->child_id, -4));
                            $newThreeDigits = str_pad($lastThreeDigits + 1, 3, '0', STR_PAD_LEFT);
                            $childnoNew = 'CH/' . $formattedYear . '/' . $newThreeDigits . 'M';

                            $lastThreeDigitsEnrollment = intval(substr($Enrollmentdetails->enrollment_child_num, -4));
                            $newThreeDigitsEnrollment = str_pad($lastThreeDigitsEnrollment + 1, 3, '0', STR_PAD_LEFT);
                            $enrollmentnum = 'EN/' . $formattedYear . '/' . $formattedMonth . '/' . $newThreeDigitsEnrollment . 'M';
                        }
                        // Enrollment Details
                        $enrollment_id = DB::table('enrollment_details')
                            ->insertGetId([
                                'user_id' => $user_id,
                                'enrollment_child_num' => $enrollmentnum,
                                'child_name' => $data[$i][1],
                                'child_dob' => $formattedDate_DOB,
                                'child_contact_email' => $data[$i][2],
                                'child_contact_phone' => $data[$i][4],
                                'child_alter_phone' => $data[$i][15],
                                'child_id' => $childnoNew,
                                'child_school_name_address' => $data[$i][5],
                                'child_gender' => $data[$i][6],
                                'child_mother_caretaker_name' => $data[$i][7],
                                'child_father_guardian_name' => $data[$i][8],
                                'child_contact_address' => $data[$i][9],
                                'consent_aggrement' => 'Agreed',
                                'status' => 'Submitted',
                                'services_from_elina' => $services_from_elina,
                                'how_knowabt_elina' => $how_knowabt_elina,
                                'created_date' => $formattedDateTime,
                                'active_flag' => '0',

                            ]);

                        // OVM Details
                        // $ovm_meetingID = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                        // $sample =substr(str_shuffle($ovm_meetingID), 0, 8);
                        $OVMdetails = DB::table('enrollment_details as ed')
                            ->join('ovm_meeting_isc_feedback as omif', 'omif.enrollment_id', '=', 'ed.enrollment_child_num')
                            ->join('users as us', 'us.id', '=', 'ed.user_id')
                            ->where('us.user_type', '=', 'MA')
                            ->orderBy('ed.enrollment_id', 'desc')
                            ->first();
                        if ($OVMdetails == null) {

                            $OVM_ID = 'OVM-1/' . $formattedYear . '/' . $formattedMonth . '/001M';

                        } else {
                            $lastThreeDigitsEnrollment = intval(substr($OVMdetails->ovm_meeting_unique, -4));
                            $newThreeDigitsEnrollment = str_pad($lastThreeDigitsEnrollment + 1, 3, '0', STR_PAD_LEFT);
                            $OVM_ID = 'OVM-1/' . $formattedYear . '/' . $formattedMonth . '/' . $newThreeDigitsEnrollment . 'M';
                        }

                        if ($OVMdetails == null) {

                            $OVM_ID2 = 'OVM-2/' . $formattedYear . '/' . $formattedMonth . '/001M';

                        } else {
                            $lastThreeDigitsEnrollment = intval(substr($OVMdetails->ovm_meeting_unique, -4));
                            $newThreeDigitsEnrollment = str_pad($lastThreeDigitsEnrollment + 1, 3, '0', STR_PAD_LEFT);
                            $OVM_ID2 = 'OVM-2/' . $formattedYear . '/' . $formattedMonth . '/' . $newThreeDigitsEnrollment . 'M';
                        }

                        $co_ordinatordetails1 = DB::table('users as us')
                            ->select('id', 'name', 'email')
                            ->where('us.email', '=', $data[$i][13])
                            ->get();

                        $collection = $co_ordinatordetails1->first();
                        $data1 = [
                            "id" => $collection->id,
                            "name" => $collection->name,
                            "email" => $collection->email,
                        ];
                        $co_ordinator1 = json_encode($data1);

                        $co_ordinatordetails2 = DB::table('users as us')
                            ->where('us.email', '=', $data[$i][14])
                            ->get();

                        $collection2 = $co_ordinatordetails2->first();
                        $data2 = [
                            "id" => $collection2->id,
                            "name" => $collection2->name,
                            "email" => $collection2->email,
                        ];
                        $co_ordinator2 = json_encode($data2);
                        $insertData = [];
                        array_push(
                            $insertData,
                            [
                                'enrollment_id' => $enrollmentnum,
                                'ovm_meeting_unique' => $OVM_ID,
                                'user_id' => $user_id,
                                'child_id' => $childnoNew,
                                'child_name' => $data[$i][1],
                                'meeting_to' => $data[$i][2],
                                'is_coordinator1' => $co_ordinator1,
                                'is_coordinator2' => $co_ordinator2,
                                'meeting_subject' => 'OVM Meeting-' . $data[$i][1],
                                'meeting_startdate' => $OVM_date,
                                'meeting_starttime' => $OVM_time,
                                'meeting_endtime' => $OVM_time,
                                'meeting_enddate' => $OVM_date,
                                'meeting_status' => 'Completed',
                                'active_flag' => '1',
                                'meeting_location' => 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India',
                            ]
                        );

                        $insertData2 = [];
                        array_push(
                            $insertData2,
                            [
                                'enrollment_id' => $enrollmentnum,
                                'ovm_meeting_unique' => $OVM_ID2,
                                'user_id' => $user_id,
                                'child_id' => $childnoNew,
                                'child_name' => $data[$i][1],
                                'meeting_to' => $data[$i][2],
                                'is_coordinator1' => $co_ordinator1,
                                'is_coordinator2' => $co_ordinator2,
                                'meeting_subject' => 'OVM Meeting-' . $data[$i][1],
                                'meeting_startdate' => $OVM_date,
                                'meeting_starttime' => $OVM_time,
                                'meeting_endtime' => $OVM_time,
                                'meeting_enddate' => $OVM_date,
                                'meeting_status' => 'Completed',
                                'active_flag' => '1',
                                'meeting_location' => 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India',
                            ]
                        );
                        // OVM Allocation
                        DB::table('ovm_allocation')->insertGetId([
                            'enrollment_id' => $enrollment_id,
                            'child_id' => $childnoNew,
                            'is_coordinator1' => $co_ordinator1,
                            'is_coordinator2' => $co_ordinator2,
                            'child_name' => $data[$i][1],
                            'meeting_startdate' => $OVM_date,
                            'meeting_enddate' => $OVM_date,
                            'meeting_starttime' => $OVM_time,
                            'meeting_endtime' => $OVM_time,
                            'meeting_location' => 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India',
                            'meeting_startdate2' => $OVM_date,
                            'meeting_enddate2' => $OVM_date,
                            'meeting_starttime2' => $OVM_time,
                            'meeting_endtime2' => $OVM_time,
                            'meeting_location2' => 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India',
                            'month' => '2020-10',
                            'week' => '1',
                            'comments' => ''
                        ]);

                        $ovm_meeting_id = DB::table('ovm_meeting_details')->insertGetId($insertData);
                        $ovm2_meeting_id = DB::table('ovm_meeting_2_details')->insertGetId($insertData2);
                        $ovm_IDS = [$ovm_meeting_id, $ovm2_meeting_id];
                        // for ($k = 0; $k < count($ovm_IDS); $k++) {
                            DB::table('ovm_meeting_isc_feedback')
                                ->insertGetId([
                                    'enrollment_id' => $enrollmentnum,
                                    'ovm_meeting_id' => $ovm_meeting_id,
                                    'ovm_meeting_unique' => $OVM_ID,
                                    'child_id' => $childnoNew,
                                    'child_name' => $data[$i][1],
                                    'status' => 'Completed',
                                    'report_flag' => '1',
                                    'is_coordinator_id' => $co_ordinator1,
                                    'created_at' => $formattedDateTime,

                                ]);
                        // }

                        // Report Details
                        $report_value = ['7', '9'];

                        for ($j = 0; $j < count($report_value); $j++) {

                            DB::table('reports_copy')
                                ->insertGetId([
                                    'enrollment_id' => $enrollment_id,
                                    'report_type' => $report_value[$j],
                                    'status' => 'Published',
                                    'created_date' => $formattedDateTime,

                                ]);
                        }

                        $referral_reportID = DB::table('referral_report')
                            ->insertGetId([
                                'enrollment_id' => $enrollment_id,
                                'status' => 'Published',
                                'created_date' => $formattedDateTime,

                            ]);

                        DB::table('referral_report_details')
                            ->insertGetId([
                                'report_id' => $referral_reportID,
                                'recommendation_area' => '9',

                            ]);

                        // Crete Folder
                        $report_type = ['ovm_report', 'ovm_assessment', 'assessment_report', 'recommendation_report', 'referral_report'];
                        for ($m = 0; $m < count($report_type); $m++) {
                            $basePath = "C:\\Apache24\\htdocs\\Elina_ISMS\\web\\public\\" . $report_type[$m];
                            $folderName = $data[$i][2];

                            $fullPath = $basePath . DIRECTORY_SEPARATOR . $folderName;

                            if (!is_dir($fullPath)) {
                                // Check if the folder doesn't exist
                                if (mkdir($fullPath)) {
                                    // echo "Folder created successfully!";
                                } else {
                                    // echo "Error creating folder.";
                                }
                            }

                        }

                    }
                DB::commit();

                return Response::json(array(
                    'status' => 'Success',
                    'message' => 'Data Migration Done Successfully',
                    'status' => '200',
                ), 200);
            } else {
                return Response::json(array(
                    'status' => 'Unauthentiacted',
                    'message' => 'Authentication Failed',
                    'status' => '401',
                ), 200);

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
