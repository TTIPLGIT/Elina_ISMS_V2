<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SailReportRepublish extends BaseController
{
    public function GetData(Request $request, $id)
    {
        $logMethod = 'Method => SailReportRepublish => GetData';
        try {            
            if ($id == null) {
                $results = DB::table('reports_copy')
                    ->join('reports', 'reports.reports_id', '=', 'reports_copy.report_type')
                    ->join('enrollment_details', 'enrollment_details.enrollment_id', '=', 'reports_copy.enrollment_id')
                    ->where('reports_copy.status', 'Published')
                    ->select('enrollment_details.enrollment_child_num', 'reports_copy.report_id', 'reports_copy.enrollment_id', 'enrollment_details.child_name')
                    ->get();
            } else {
                $results = DB::table('reports_copy')
                    ->join('reports', 'reports.reports_id', '=', 'reports_copy.report_type')
                    ->join('enrollment_details', 'enrollment_details.enrollment_id', '=', 'reports_copy.enrollment_id')
                    ->where('reports_copy.status', 'Published')
                    ->select('enrollment_details.enrollment_child_num', 'reports_copy.report_id', 'reports_copy.enrollment_id', 'enrollment_details.child_name')
                    ->get();
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $results;
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
