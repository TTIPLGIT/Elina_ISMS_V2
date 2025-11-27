<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SchedulePhoneCall;
use App\Mail\ScheduleOnlineMeeting;
use App\Mail\ScheduleOnlineMeetingadmin;
use App\Mail\helpyou;
use App\Mail\helpyouadmin;
use App\Mail\SchedulePhoneCalladmin;
use App\Mail\blog_comment;
use App\Mail\blog_commentadmin;
use App\Mail\event_register;
use App\Mail\event_register_admin;
use DateTime;
use Validator;

class Elina_webportalController extends BaseController
{
    public function schedule_phone(Request $request)
    {            
        try {
            $method = 'Method => Elina_webportalController => schedule_phone';
            $input = [
                'recaptcha' => $request->input('g-recaptcha-response')
            ];
    
            $rules = [
                'recaptcha' => 'required'
            ];
    
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to(config('setting.web_portal') . "Contactus?message=Captcha Failed");
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'callnumber' => $request->callnumber,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => date('h:i a', strtotime($request->schedule_time))
            ];
    

            DB::transaction(function () use ($request , $input) {
                $screen = DB::table('webportal_newsletter')->insertGetId([
                    'name' => $request->name,
                    'email_id' => $request->email,
                    'phone_no' => $request->callnumber,
                    'shedule_date' => $request->schedule_date,
                    'shedule_time' => $request->schedule_time,
                    'meeting_type' => 1,
                    // 'created_by' => auth()->user()->id,
                    'create_at' => NOW()
                ]);
            });

            Mail::to($data['email'])->send(new SchedulePhoneCall($data));
            Mail::to(config('setting.webportal.newsletter_call'))->send(new SchedulePhoneCalladmin($data));

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


    public function schedule_meeting(Request $request)
    {
        //  return $request; exit;
        // $dateString = $request->online_date;
        // $date = Carbon::createFromFormat('Y-m-d', $dateString);
        // $formattedDate = $date->format('l, F j, Y');
        $input = [
            'recaptcha' => $request->input('g-recaptcha-response')
        ];

        $rules = [
            'recaptcha' => 'required'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->to(config('setting.web_portal') . "Contactus?message=Captcha Failed");
        }
        $data = [
            'name' => $request->meeting_name,
            'email' => $request->onlinemail,
            'meetingnumber' => $request->meetingnumber,
            'online_date' => $request->online_date,
            'online_time' => date('h:i a', strtotime($request->online_time)),
        ];
        $screen = DB::table('webportal_newsletter')->insertGetId([
            'name' => $request->meeting_name,
            'email_id' => $request->onlinemail,
            'phone_no' => $request->meetingnumber,
            'shedule_date' => $request->online_date,
            'shedule_time' => $request->online_time,
            'meeting_type' => 2,
            // 'created_by' => auth()->user()->id,
            'create_at' => NOW()
        ]);
        Mail::to($data['email'])->send(new ScheduleOnlineMeeting($data));
        Mail::to(config('setting.webportal.newsletter_meeting'))->send(new ScheduleOnlineMeetingadmin($data));
        // http://localhost:10/Elina_webportal/Contactus
        return redirect()->to(config('setting.web_portal') . "Contactus?message=Thanks for subscribing");
        // return Redirect::back();
        // return true;

    }


    // public function help_you(Request $request)
    // {
    //     // return $request; exit;

    //     // $challenges_parent =  $request->challenges_parent;
    //     // $challenges_parent_name = implode($challenges_parent);
    //     $challenges_parent = $request->challenges_parent;
    //     $separator = ", "; // Specify the separator you want to use, such as a comma followed by a space
    //     $challenges_parent_name = implode($separator, $challenges_parent);

    //     $data = [
    //         'name' => $request->name,
    //         'email' => $request->email_address,
    //         'contact_no' => $request->contact_no,
    //         'gender' => $request->gender,
    //         'age' => $request->age,
    //         'challges_parent' => $challenges_parent_name,
    //     ];

    //     $screen = DB::table('webportal_may_help_you')->insertGetId([
    //         'name' => $request->name,
    //         'email_id' => $request->email_address,
    //         'phone_no' => $request->contact_no,
    //         'gender' => $request->gender,
    //         'age' => $request->age,
    //         'challenges' => $data['challges_parent'],
    //         'create_at' => NOW()
    //     ]);
    //     Mail::to($data['email'])->send(new helpyou($data));

    //     //Mail::to('aparna@elinaservices.in')->cc('rama@elinaservices.in')->send(new helpyouadmin($data));
    //     Mail::to(config('setting.web_portal_mail.to'))->cc(config('setting.web_portal_mail.aparna'))->send(new helpyouadmin($data));

    //     // http://localhost:10/Elina_webportal/Contactus
    //     return redirect()->to(config('setting.web_portal')."Elina_services?message='Your Application has been submitted successfully'");
    //     // return Redirect::back();
    //     // return true;

    // }

    public function help_you(Request $request)
    {     
        try {
            $method = 'Method => Elina_webportalController => help_you';

            $input = [
                'recaptcha' => $request->input('g-recaptcha-response')
            ];
    
            $rules = [
                'recaptcha' => 'required'
            ];
            $existingEmails = DB::table('enrollment_details')->pluck('child_contact_email')->toArray();
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to(config('setting.web_portal') . "Contactus?message=Captcha Failed");
            }        
            if (in_array($request->email_address, $existingEmails)) {
                return redirect()->to(config('setting.web_portal') . "Contactus?message=Email already exists");
            }
            $dob = $request->child_dob;
            $birthdate = DateTime::createFromFormat('d/m/Y', $dob);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthdate)->y;
    
            $data = [
                'name' => $request->name,
                'parentname' => $request->parentname,
                'gender' => $request->gender,
                'childrelationship' => $request->childrelationship,
                'child_dob' => $request->child_dob,
                'contact_no' => $request->contact_no,
                'child_school' => $request->child_school,
                'email' => $request->email_address,
                'knowaboutUs' => $request->knowaboutUs,
                'contact_reason' => ($request->others_reason != null && $request->contact_reason == 'others' ? $request->others_reason : $request->contact_reason),
                'others_reason' => $request->others_reason,
                'age' => $age,
                'date' => NOW(),
                // 'challges_parent' => $challenges_parent_name,
            ];
    
            DB::transaction(function () use ($data) {

                DB::table('webportal_may_help_you')->insertGetId([
                    'name' => $data['name'],
                    'parentname' => $data['parentname'],
                    'childrelationship' => $data['childrelationship'],
                    'child_dob' => $data['child_dob'],
                    'email_id' => $data['email'],
                    'phone_no' => $data['contact_no'],
                    'child_school' => $data['child_school'],
                    'gender' => $data['gender'],
                    'knowaboutUs' => $data['knowaboutUs'],
                    'contact_reason' => ($data['others_reason'] != null && $data['contact_reason'] == 'others' ? $data['others_reason'] : $data['contact_reason']),
                    // 'others_reason' => $request['others_reason'],
                    'age' => $data['age'],
                    // 'challenges' => $data['challges_parent'],
                    'create_at' => NOW()
                ]);
                Mail::to($data['email'])->send(new helpyou($data));        
                Mail::to(config('setting.webportal.journey'))->send(new helpyouadmin($data));
        
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


    public function blog_comment(Request $request)
    {
        // $this->WriteFileLog($request);
        // $input = [
        //     'recaptcha' => $request->input('g-recaptcha-response')
        // ];

        // $rules = [
        //     'recaptcha' => 'required'
        // ];

        // $validator = Validator::make($input, $rules);
        // if ($validator->fails()) {
        //     return false;
        // }
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => isset($request->subject) ? $request->subject : "",
            'comment' => $request->subject,
            'heading' => isset($request->subject) ? $request->subject : "",
        ];
        // $this->WriteFileLog($data);
        $screen = DB::table('webportal_blog_comment')->insertGetId([
            'name' => $request->name,
            'phone' => $request->phone,
            'email_id' => $request->email,
            'subject' => isset($request->subject) ? $request->subject : "",
            'heading' => 'Heading',
            // 'created_by' => auth()->user()->id,
            'create_at' => NOW()
        ]);
        Mail::to($data['email'])->send(new blog_comment($data));
        Mail::to(config('setting.webportal.comment'))->send(new blog_commentadmin($data));

        // http://localhost:10/Elina_webportal/Contactus
        // return redirect()->to(config('setting.web_portal') . 'blog');
        // return Redirect::back();
        return true;
        // return response()->json('You have successfully added a comment');
        return "You have successfully added a comment";
    }

    public function events_registration(Request $request)
    {
        // return $request;exit;
        $input = [
            'recaptcha' => $request->input('g-recaptcha-response')
        ];

        $rules = [
            'recaptcha' => 'required'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->to(config('setting.web_portal') . "Consulting_services?message=Captcha Failed");
        }
        $data = [
            'eventName' => $request->eventName,
            'userName' => $request->userName,
            'userMail' => $request->userMail,
            'userNumber' => $request->userNumber,
            'eventId' => $request->eventId
        ];
        $validate = DB::select("SELECT * FROM webportal_events_registration WHERE eventId = '$request->eventId'
        AND (userMail = '$request->userMail' OR userNumber = '$request->userNumber')");
        // $this->WriteFileLog("SELECT * FROM webportal_events_registration WHERE eventId = '$request->eventId'
        // AND (userMail = '$request->userMail' OR userNumber = '$request->userNumber')");
        // $this->WriteFileLog($validate);
        if (json_encode($validate) == '[]') {
            // $this->WriteFileLog('if');
            DB::table('webportal_events_registration')->insertGetId([
                'eventName' => $request->eventName,
                'eventId' => $request->eventId,
                'userName' => $request->userName,
                'userMail' => $request->userMail,
                'userNumber' => $request->userNumber,
                'dateRegistred' => NOW(),
                'create_at' => NOW()
            ]);

            Mail::to($data['userMail'])->send(new event_register($data));
            Mail::to(config('setting.webportal.event'))->send(new event_register_admin($data));
            return redirect()->to(config('setting.web_portal') . "Consulting_services?message=You have successfully registered for the event");
        } else {
            // $this->WriteFileLog('else');
            return redirect()->to(config('setting.web_portal') . "Consulting_services?message=You have already registered for the event");
        }
    }
}
