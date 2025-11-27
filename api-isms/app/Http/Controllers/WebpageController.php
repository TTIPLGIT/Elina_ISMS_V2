<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\sendmailjob;
use App\Mail\ovmassessment;
use App\Mail\G2FormMail;
use App\Mail\ovmreportmail;
use App\Googl;
use DateTime;
use DateTimeZone;
use Google\Service\Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;
use Log;
use Validator;
use App\Mail\inquriesmail; 
use App\Mail\newinqueryadmin;
class WebpageController extends BaseController

{
    public function testimonial($id)
    {
		$this->WriteFileLog($id,"Hi");
        try {
            $method = 'Method => WebpageController =>testimonial';

            // $id = $this->decryptData($id);
            $row = DB::table('testimonials')
                ->select('*')
                ->where('testimonial_type', $id)
                ->get();
			
            
            $response = [
                'rows' => $row,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            // $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            // $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $row;
        } catch (\Exception $exc) {
			$this->WriteFileLog($exc);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function dailyquotes()
    {
		
        try {
            $method = 'Method => WebpageController =>dailyquotes';

            // $id = $this->decryptData($id);
            $row = DB::table('daily_quotes')
                ->select('*')
                ->where('active_flag', '0')
                ->get();
			
            
            
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row;
            // $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            // $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $row;
        } catch (\Exception $exc) {
			$this->WriteFileLog($exc);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
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
            $method = 'Method => WebpageController => storedata';
            $id = $request->emailid;
            $exist = DB::select("SELECT * FROM news_letters WHERE email_id='$id'");
            if(empty($exist)){

                $newsletters = DB::table('news_letters')
                    ->insertGetId([
                        'email_id' => $request->emailid,
                        'created_at' => now(),
                        'created_by' => 0
                       
                    ]);
                }
                else{
                    return "User Already Subscribed";
                }
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $newsletters;
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

    public function newinquires(Request $request)
    {
        try {
            $method = 'Method => WebpageController => storedata';
            $input = [
                'recaptcha' => $request->input('g-recaptcha-response')
            ];
    
            $rules = [
                'recaptcha' => 'required'
            ];
    
            $validator = Validator::make($input, $rules);
            $newinquires = DB::transaction(function () use ($request) {
                $newinquires = DB::table('new_inquires')
                    ->insertGetId([
                        'firstname' => $request->first_Name,
                        'lastname' => $request->last_Name,
                        'email' => $request->email,
                        'phonenumber' => $request->phonenumber,
                        'comments' => $request->comments,
                        'created_at' => now()
                       
                    ]);
                    $data =[
                        'name' =>$request->first_Name,
                        'email' => $request->email,
                        'comments' => $request->comments,
                        'phonenumber' => $request->phonenumber

                    ];
                    Mail::to($data['email'])->send(new inquriesmail($data));
                    Mail::to(config('setting.webportal.newsletter_call'))->send(new newinqueryadmin($data));
                    return $newinquires;
                });
                
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $newinquires;
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

    public function blog_comment()
    {
		
        try {
            $method = 'Method => WebpageController =>dailyquotes';

            // $id = $this->decryptData($id);
            $row = DB::table('webportal_blog_comment')
                ->select('*')
                ->get();
			
            
            
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $row;
            // $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            // $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $row;
        } catch (\Exception $exc) {
			$this->WriteFileLog($exc);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function getSchoolsRegistration()
    {
		// $this->WriteFileLog($id,"Hi");
        try {
            $method = 'Method => WebpageController =>testimonial';

            // $id = $this->decryptData($id);
            $row = DB::table('schools_registration')
                ->select('school_name','id')
                ->get();
			
            
            $response = [
                'rows' => $row,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            // $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            // $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $row;
        } catch (\Exception $exc) {
			$this->WriteFileLog($exc);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
}