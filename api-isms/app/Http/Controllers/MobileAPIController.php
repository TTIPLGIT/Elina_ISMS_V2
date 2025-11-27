<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;



class MobileAPIController extends BaseController
{
  /**
   * Schema: feeback_master
   * Table Name: roles
   * Author: Aravinthkumar
   * Date: 24/08/2019
   * Description: Get all active records.
   */
  public function personel_details()
  {

    try {
      $activity_level = DB::select("select * from activity_level where status='0'");
      $medical_conditions = DB::select("select * from medical_conditions where status='0'");
      $rows = [
        'activity_level' => $activity_level,
        'medical_conditions' => $medical_conditions,
      ];


      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function yourplanner()
  {

    try {

      $workout_frequency = DB::select("select * from workout_schedule where status='0'");

      $rows = [

        'workout_frequency' => $workout_frequency

      ];


      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function getgoals($id)
  {
    try {
      //$id = $this->decryptData($id);

      $rows = DB::table('goals as ga')
        ->select('ga.id', 'ga.goal_name', 'ga.goal_description', 'ga.weight_type_id', 'ga.goal_image', 'wt.weight_type_name', 'ga.youtube_link')

        ->join('weight_type as wt', 'wt.id', '=', 'ga.weight_type_id')
        ->where([['ga.status', 0], ['ga.id', $id]])
        ->get();

      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => edit', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function bmigoal($id)
  {
    try {
      //$id = $this->decryptData($id);
      $rows = DB::select("select * from user_details where status='0' and user_id=" . $id);
      // foreach ($rows as $key => $value) {
      $height = $rows[0]->height / 100;
      $weight = $rows[0]->weight;
      $BMI = $weight / ($height * $height);
      //echo $BMI; exit;
      $calculation = DB::select("select  ga.id, ga.goal_name,ga.goal_description,ga.weight_type_id,wt.weight_type_name,wt.id FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id)
      WHERE $BMI between wt.bmi_from AND wt.bmi_to ");


      return $calculation;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => edit', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function alldetails()
  {

    try {
      $workout_type = DB::select("select * from workout_type where status='0'");
      $work_order_plan = DB::select("select * from work_out_plan where status='0'");
      $workout_schedule = DB::select("select * from workout_schedule where status='0'");
      $weight_type = DB::select("select * from weight_type where status='0'");
      $users_age_group = DB::select("select * from users_age_group where status='0'");
      $medical_conditions = DB::select("select * from medical_conditions where status='0'");

      $program_details = DB::table('program_details as pd')
        ->select('pd.id', 'ug.users_age_group_name', 'wt.workout_type_name', 'pd.health_weight_name', 'pd.health_weight_description')
        ->join('workout_type as wt', 'wt.id', '=', 'pd.workout_type_id')
        ->join('users_age_group as ug', 'ug.id', '=', 'pd.users_age_group_id')
        ->where('pd.status', 0)
        ->get();

      $workoutgoal = DB::table('workorder_goals_mapping as wg')
        ->select('wg.id', 'wg.age_group_id', 'wg.level', 'wg.goal_id', 'wg.duration', 'wg.work_out_plan_id', 'gs.goal_name', 'ua.users_age_group_name', 'wp.work_out_plan_name')

        ->join('goals as gs', 'gs.id', '=', 'wg.goal_id')
        ->join('work_out_plan as wp', 'wp.id', '=', 'wg.work_out_plan_id')
        ->join('users_age_group as ua', 'ua.id', '=', 'wg.age_group_id')
        ->where('wg.status', 0)
        ->get();






      $rows = [
        'workout_type' => $workout_type,
        'work_order_plan' => $work_order_plan,
        'workout_schedule' => $workout_schedule,
        'weight_type' => $weight_type,
        'users_age_group' => $users_age_group,
        'medical_conditions' => $medical_conditions,
        'program_details' => $program_details,
        'workoutgoal' => $workoutgoal
      ];


      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => ModelApiController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function workoutdetails()
  {

    try {
      $workoutdetails = DB::select("select * from work_out_details where status='0'");
      $rows = [
        'workoutdetails' => $workoutdetails

      ];


      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function userdetails(Request $request)
  {
    //return $request;

    try {
      //$inputArray = $this->decryptData($request->requestData);
      $password_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';


      $data = [
        'email' => $request->email,
        'first_name' => $request->name,
        'address' => $request->address,
        'display_name' => $request->display_name,
        'password' => substr(str_shuffle($password_string), 0, 8),
        'gender' => $request->gender,
        'city' => $request->city,
        'state' => $request->state,
        'mobile_no' => $request->mobile_no,
        'age' => $request->age,
        'height' => $request->height,
        'weight' => $request->weight,
        'activitylevel' => $request->activitylevel,
        'medicalcondition' => $request->medicalcondition
      ];

      //echo json_encode($request->name);exit;


      $rules = [

        'first_name' => 'required',
        'age' => 'required',
        'height' => 'required',
        'weight' => 'required',
        'activitylevel' => 'required',
        'medicalcondition' => 'required',

      ];

      $messages =
        [
          'first_name.required' => 'User Name is required',
          'age.required' => 'Age is required',
          'height.required' => 'Height is required',
          'weight.required' => 'Weight is required',
          'first_name.required' => 'User Name is required',
          'medicalcondition.required' => 'Medical Condition is required',
          'activitylevel.required' => 'Activity Level is required',
        ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        $firstname = DB::select("SELECT count(*) AS count FROM `user_details` WHERE status=0 AND first_name='" . $request->name . "'");
        //echo json_encode($firstname[0]->count);exit;

        if ($firstname[0]->count > 0) {
          $data = [

            'first_name' => $request->name,

          ];


          $rules = [

            'first_name' => 'required',

          ];

          $messages =  [

            'first_name.required' => 'User Name is Already Exist',

          ];

          $validator = Validator::make(["User Name is Already Exist"], $rules, $messages);

          return $this->sendError('Validation Error.', $validator->errors(), 400);
        } else {

          // DB::transaction(function() use($data){
          $user_id = DB::table('users')->insertGetId([
            'name' => $data['first_name'],
            'email' => $data['email'],
            'password' =>  bcrypt($data['password']),
            'display_name' => $data['display_name'],

            'status' => 0,
            'created_by' => 1,
            'created_at' => NOW()
          ]);


          $user_details_id = DB::table('user_details')->insertGetId([
            'user_id' => $user_id,
            'first_name' => $data['first_name'],

            'address' => $data['address'],
            'mobile_no' => $data['mobile_no'],
            'gender' => $data['gender'],
            'city' => $data['city'],
            'state' => $data['state'],
            'age' => $data['age'],
            'height' => $data['height'],
            'weight' => $data['weight'],
            'activitylevel' => $data['activitylevel'],
            'medicalcondition' => $data['medicalcondition'],
            'status' => 0,
            'cancel_plan_Status' => 0,
            'created_by' => 1,
            'created_at' => NOW()
          ]);


          $notification_id = DB::table('notifications')->insertGetId([
            'type' => 'Registration',
            'latest' => '1',
            'name' => 'New User Registered By TFZ',
            'notifiable_type' => $data['first_name'] . ' Registered Successfully',
            'notifiable_id' => '1',
            'data' => 'New User Created',
            'notification_details_id' => $user_id,
            'status' => 0,
            'created_by' => 1,
            'created_at' => NOW(),
            'updated_at' => NOW()
          ]);





          $this->sendAuditLog('user_details', $user_id, 'Create', 'Create new User_Details', 1, NOW());
          // }); 


          // foreach ($rows as $key => $value) {
          $height = $request->height / 100;
          $weight = $request->weight;
          $BMI = $weight / ($height * $height);
          //echo $BMI; exit;

          $gender = $request->gender;
          $bmr_height = $request->height;
          $age = $request->age;



          if ($gender == 'male') {
            $BMR = 66.4730 + (13.7516 * $weight) + (5.003 * $bmr_height) - (6.7500 * $age);
          } else if ($gender == 'female') {
            $BMR =  655.0955 + (9.5634 * $weight) + (1.8496 * $bmr_height) - (4.6756 * $age);
          } else {
            $BMR_male = 66.4730 + (13.7516 * $weight) + (5.003 * $bmr_height) - (6.7500 * $age);
            $BMR_female =  655.0955 + (9.5634 * $weight) + (1.8496 * $bmr_height) - (4.6756 * $age);
            $BMR = ($BMR_male +  $BMR_female) / 2;
          }

          $activitylevel = $request->activitylevel;

          $multiplication_factor = DB::select("select act.multiplication_factor from activity_level act where act.activity_name = '" . $activitylevel . "'");
          $calories = $multiplication_factor[0]->multiplication_factor * $BMR;

          //echo $calories;exit;

          if ($age <= 60) {

            if ($BMI >= 18.5 && $BMI <= 24.9) {
              $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,'No' as is_recommended from goals ga where status=0 and ga.goal_name != 'Senior Citizen Fitness'");
            } else {
              $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,ga.is_recommended FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id)
            WHERE $BMI between wt.bmi_from AND wt.bmi_to and ga.status=0 
            UNION select ga.id, ga.goal_name,ga.goal_description,ga.is_recommended FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id) where ga.status=0 AND wt.weight_type_name='Normal or healthy'  ");
            }
          }
          if ($age > 60) {
            $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,'No' as is_recommended from goals ga where status=0 and ga.goal_name = 'Senior Citizen Fitness'");
          }
          DB::table('user_details')
            ->where('user_id', $user_id)
            ->update([
              'bmi' => $BMI,
              'bmr' => $BMR,

              'updated_by' => $user_id,
              'updated_at' => NOW()
            ]);


          $rows = [
            'Success' => "True",
            'user_id' => $user_id,
            'goals' => $goals,
            'BMI' => $BMI,
            'BMR' => $BMR,
            'calories' => $calories



          ];

          return $rows;
        }


        // return $this->sendResponse('Success', 'User created successfully.');               
      }
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  //getuserdetails
  public function getuserdetails(Request $request)
  {
    //return $request;

    try {
      //$inputArray = $this->decryptData($request->requestData);
      $password_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
      $data = [
        'email' => $request->email,
        'first_name' => $request->name,
        'address' => $request->address,
        'display_name' => $request->display_name,
        'password' => substr(str_shuffle($password_string), 0, 8),
        'gender' => $request->gender,
        'city' => $request->city,
        'state' => $request->state,
        'mobile_no' => $request->mobile_no,
        'age' => $request->age,
        'height' => $request->height,
        'weight' => $request->weight,
        'activitylevel' => $request->activitylevel,
        'medicalcondition' => $request->medicalcondition
      ];



      $rules = [

        'first_name' => 'required',
        'age' => 'required',
        'height' => 'required',
        'weight' => 'required',
        'activitylevel' => 'required',
        'medicalcondition' => 'required',

      ];

      $messages =
        [
          'first_name.required' => 'User Name is required',
          'age.required' => 'Age is required',
          'height.required' => 'Height is required',
          'weight.required' => 'Weight is required',
          'first_name.required' => 'User Name is required',
          'medicalcondition.required' => 'Medical Condition is required',
          'activitylevel.required' => 'Activity Level is required',
        ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        // foreach ($rows as $key => $value) {
        $height = $request->height / 100;
        $weight = $request->weight;
        $BMI = $weight / ($height * $height);
        //echo $BMI; exit;

        $gender = $request->gender;
        $bmr_height = $request->height;
        $age = $request->age;



        if ($gender == 'male') {
          $BMR = 66.4730 + (13.7516 * $weight) + (5.003 * $bmr_height) - (6.7500 * $age);
        } else if ($gender == 'female') {
          $BMR =  655.0955 + (9.5634 * $weight) + (1.8496 * $bmr_height) - (4.6756 * $age);
        } else {
          $BMR_male = 66.4730 + (13.7516 * $weight) + (5.003 * $bmr_height) - (6.7500 * $age);
          $BMR_female =  655.0955 + (9.5634 * $weight) + (1.8496 * $bmr_height) - (4.6756 * $age);
          $BMR = ($BMR_male +  $BMR_female) / 2;
        }

        $activitylevel = $request->activitylevel;

        //echo $activitylevel;exit;

        $multiplication_factor = DB::select("select act.multiplication_factor from activity_level act where act.activity_name = '" . $activitylevel . "'");
        $calories = $multiplication_factor[0]->multiplication_factor * $BMR;

        //echo $calories;exit;

        if ($age <= 60) {

          if ($BMI >= 18.5 && $BMI <= 24.9) {
            $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,'No' as is_recommended from goals ga where status=0 and ga.goal_name != 'Senior Citizen Fitness'");
          } else {
            $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,ga.is_recommended FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id)
            WHERE $BMI between wt.bmi_from AND wt.bmi_to and ga.status=0 
            UNION select ga.id, ga.goal_name,ga.goal_description,ga.is_recommended FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id) where ga.status=0 AND wt.weight_type_name='Normal or healthy'  ");
          }
        }
        if ($age > 60) {
          $goals = DB::select("select ga.id, ga.goal_name,ga.goal_description,'No' as is_recommended from goals ga where status=0 and ga.goal_name = 'Senior Citizen Fitness'");
        }


        $rows = [
          'Success' => "True",
          'goals' => $goals,
          'BMI' => $BMI,
          'BMR' => $BMR,
          'calories' => $calories



        ];

        return $rows;
        // return $this->sendResponse('Success', 'User created successfully.');               
      }
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  // public function workouttype()
  // {

  //   try
  //   {

  //     $workout_type = DB::select("select * from workout_type where status='0' order by order_by asc");

  //     $rows = [

  //       'workout_type' =>$workout_type

  //     ];


  //     return $rows;
  //   }catch(\Exception $exc){
  //     return $this->sendLog('Method => MobileAPIController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
  //   }
  // }
  public function workoutplan()
  {

    try {

      $workoutplan = DB::select("select * from work_out_plan where status='0'");

      $rows = [

        'workoutplan' => $workoutplan

      ];


      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function workout_details()
  {
    try {
      $rows = DB::table('work_out_details as wo')
        ->select('wo.id', 'ws.workout_schedule', 'wp.work_out_plan_name', 'us.users_age_group_name', 'wt.workout_type_name', 'wo.sets', 'wo.met_value', 'wo.reps', 'wo.time', 'wo.calories_per_ex', 'wo.youtube_link', 'wo.goal_id', 'wo.exercise_id', 'wo.workout_day', 'go.goal_name', 'ex.exercise_name', 'wo.work_order_plan_id', 'wo.workout_schedule_id', 'wo.users_age_group_id', 'wo.workout_type_id', 'wd.work_out_plan_id', 'wd.work_out_day',)

        ->join('work_out_plan as wp', 'wp.id', '=', 'wo.work_order_plan_id')
        ->join('workout_schedule as ws', 'ws.id', '=', 'wo.workout_schedule_id')
        ->join('users_age_group as us', 'us.id', '=', 'wo.users_age_group_id')
        ->join('workout_type as wt', 'wt.id', '=', 'wo.workout_type_id')
        ->join('exercise as ex', 'ex.id', '=', 'wo.exercise_id')
        ->join('goals as go', 'go.id', '=', 'wo.goal_id')
        ->join('work_out_plan_day as wd', 'wd.id', '=', 'wo.workout_day')

        ->where('wo.status', 0)
        ->get();
      //echo   $rows;exit;        
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => WorkOutDetailsController => index', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function details_by_user(Request $request)
  {
    //return $request;

    try {

      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,

        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'user_id' => $request->user_id,


      ];

      // \Log::info(json_encode($data));

      //echo json_encode($data);exit;


      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {



        $userdetails = DB::select("select us.age, us.gender from  user_details us where status='0' and us.user_id= " . $data['user_id']);

        //echo json_encode(count($userdetails));exit;

        $user_age_work = $userdetails[0]->age;
        $user_gender_work = $userdetails[0]->gender;


        $useragegroup = DB::select("select ug.id,ug.users_age_group_name FROM users_age_group ug 
      WHERE status='0' and $user_age_work between ug.users_age_from AND ug.users_age_to ");

        $useragegroupid = $useragegroup[0]->id;
        // echo ($useragegroupid);exit;

        // $calculation =DB::select("select  ga.id, ga.goal_name,ga.goal_description,ga.weight_type_id,wt.weight_type_name,wt.id FROM weight_type wt join goals ga ON ( wt.id=ga.weight_type_id)
        //      WHERE $BMI between wt.bmi_from AND wt.bmi_to ");



        $work_out_plan = DB::select("SELECT distinct workout_day FROM work_out_details where workout_schedule_id =" . $data['workout_frequency_id'] . " and goal_id = " . $data['goal_id'] . " and work_order_plan_id = " . $data['workout_plan_id'] . " and workout_type_id = " . $data['workout_type_id'] . "  and users_age_group_id = " . $useragegroupid . " and gender = '" . $user_gender_work . "'");


        //echo json_encode($work_out_plan[0].count);exit;

        // $multiplication_factor = DB::select ("select act.multiplication_factor from activity_level act where act.activity_name = '".$activitylevel."'");




        // DB::transaction(function() use($data){



        // echo "select * from details_by_user where where workout_frequency_id =" .$data['workout_frequency_id'] . " and goal_id = " .$data['goal_id']. " and workout_plan_id = ".$data['workout_plan_id'] . " and workout_type_id = ".$data['workout_type_id']." and workout_day=1 and user_id=".$data['user_id']; exit;

        $if_exists = DB::select("select * from details_by_user  where is_cancelled='0' and  workout_frequency_id =" . $data['workout_frequency_id'] . " and goal_id = " . $data['goal_id'] . " and workout_plan_id = " . $data['workout_plan_id'] . " and workout_type_id = " . $data['workout_type_id'] . " and user_id=" . $data['user_id'] . " and users_age_group_id = " . $useragegroupid . " and gender = '" . $user_gender_work . "'");

        //echo json_encode($if_exists);exit; 

        if ($work_out_plan != null) {

          if ($if_exists == null) {
            DB::table('details_by_user')
              ->where('user_id', $data['user_id'])
              ->update([
                'is_cancelled' => '1',
                'updated_by' => $data['user_id'],
                'updated_at' => NOW()
              ]);

            for ($work_out = 0; $work_out < count($work_out_plan); $work_out++) {

              // echo json_encode($work_out_plan->workout_day);exit;

              $day = $work_out + 1;

              $details_by_user = DB::table('details_by_user')->insertGetId([
                'workout_frequency_id' => $data['workout_frequency_id'],
                'goal_id' => $data['goal_id'],
                'workout_plan_id' => $data['workout_plan_id'],
                'workout_type_id' => $data['workout_type_id'],
                'workout_day' => $day,
                'gender' => $user_gender_work,
                'users_age_group_id' => $useragegroupid,
                'user_id' => $data['user_id'],

                'status' => 0,
                'created_by' => 1,
                'created_at' => NOW(),
                'Workout_Date' => now()->addDay($work_out)->format('Y-m-d')
              ]);





              $work_out_details = DB::select("SELECT * FROM work_out_details where status='0' and workout_schedule_id =" . $data['workout_frequency_id'] . " and goal_id = " . $data['goal_id'] . " and work_order_plan_id = " . $data['workout_plan_id'] . " and workout_type_id = " . $data['workout_type_id'] . " and workout_day=" . $day . " and users_age_group_id = " . $useragegroupid . " and gender = '" . $user_gender_work . "'");

              //echo json_encode($work_out_details);exit();

              // $sets=$work_out_details[0]->sets;
              // $reps=$work_out_details[0]->reps;
              // $met_value=$work_out_details[0]->met_value;
              // $time=$work_out_details[0]->time;
              // $minutes=$time / 60;

              // $weight=DB::select("SELECT ud.weight FROM  user_details ud  where user_id=".$data['user_id']);
              // $userweight=$weight[0]->weight;

              // $calories_per_ex = $met_value * $userweight * ($minutes /60) + $met_value * $userweight * ($sets * reps * 1.4) / (3660);

              // Final Formula = MET Value * Body weight * (mins/60) + MET Value * Body weight * (set * reps * 1.4) / (3660)

              foreach ($work_out_details as $key => $work_out_detailss) {
                $details_by_user_exercize = DB::table('details_by_user_exercize')->insertGetId([
                  'details_by_user_id' => $details_by_user,
                  'work_out_details_id' => $work_out_detailss->id,
                  'exercise_id' => $work_out_detailss->exercise_id,
                  'user_id' => $data['user_id'],
                  'status' => 0,
                  'created_by' => 1,
                  'created_at' => NOW()
                ]);

                DB::table('user_details')
                  ->where('user_id', $data['user_id'])
                  ->update([
                    'cancel_plan_Status' => '0'
                  ]);
              }
            }
          }
        } else {
          return $this->sendResponse('fail', 'workout is not there for Intersex.');
        }




        $reg_date1 = DB::select("SELECT distinct  DATE_FORMAT(created_at, '%Y-%m-%d')  AS reg_date FROM details_by_user WHERE user_id=" . $data['user_id']);
        // echo "SELECT distinct  DATE_FORMAT(created_at, '%Y-%m-%d')  AS reg_date FROM details_by_user WHERE user_id=".$data['user_id'];exit;
        if ($reg_date1 == null) {
          $current_date1 = DB::select("SELECT CURDATE() as curr_date");
          $current_date = $current_date1[0]->curr_date;

          $reg_date = "0";
        }
        // SELECT SUM(case when dbue.points IS NULL then 0 ELSE dbue.points END) AS points
        else {

          $current_date1 = DB::select("SELECT CURDATE() as curr_date");
          $current_date = NOW()->format('Y-m-d');
          //echo json_encode($current_date);
          //echo json_encode(NOW()->format('Y-m-d'));exit;
          $reg_date = $reg_date1[0]->reg_date;
        }
        $workout_daynew1 = DB::select("SELECT DATEDIFF( '$current_date','$reg_date') AS workout_day");
        $workout_daynew = $workout_daynew1[0]->workout_day;

        $workout_day = 1;
        // $workout_daynew = $data['workout_day'];
        $new_work_out_day = $workout_day + $workout_daynew;;

        $newdate = NOW()->format('Y-m-d');

        $work_out_day_count = DB::table('details_by_user')
          ->where([[DB::raw("(DATE_FORMAT(Workout_Date,'%Y-%m-%d'))"), NOW()->format('Y-m-d')], ['user_id', $data['user_id']], ['is_cancelled', 0]])
          ->select('Workout_Day')
          ->get();

        $workoutdaycount = $work_out_day_count[0]->Workout_Day;



        //echo $workoutdaycount;exit;
        // ['status', 0],['is_cancelled', 0],
        //$work_out_date =DB::select("SELECT * FROM details_by_user WHERE is_cancelled = '0' AND status = '0' AND date_format(Workout_Date,'%Y-%m-%d')=date_format(".$newdate.",'%Y-%m-%d') AND  user_id=".$data['user_id']);

        $work_out_plan_header = DB::select("SELECT dbu.id as workout_details_by_user_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,
  dbu.workout_type_id,dbu.workout_day,dbu.user_id,g.goal_name,CONCAT('Day ',dbu.workout_day) AS workout_day_string,wop.work_out_plan_name,wop.work_out_plan_count AS work_out_plan_days 
  FROM details_by_user dbu 
  INNER JOIN goals g ON (g.id = dbu.goal_id)
  INNER JOIN work_out_plan wop ON (wop.id = dbu.workout_plan_id)
  WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $workoutdaycount . " AND user_id=" . $data['user_id']);

        //echo json_encode($work_out_plan_header);exit;


        $work_out_plan_excercise = DB::select("SELECT dbue.id as details_by_user_exercize_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id,dbu.workout_day,dbu.user_id,g.goal_name,ex.id as exercise_id,ex.exercise_name,wod.sets,wod.met_value,wod.reps,wod.youtube_link,wod.workout_image,wod.time,wod.rest 
  FROM details_by_user dbu 
  INNER JOIN goals g ON (g.id = dbu.goal_id)
  INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
  INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
  INNER JOIN exercise ex ON (ex.id = wod.exercise_id AND ex.is_alternate IS NULL)
  INNER JOIN users us ON (us.id = dbu.user_id)

  WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $workoutdaycount . " AND dbu.user_id = " . $data['user_id']);

        //echo json_encode($work_out_plan_excercise);exit;

        // echo "SELECT dbue.id as details_by_user_exercize_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id,dbu.workout_day,dbu.user_id,g.goal_name,ex.id as exercise_id,ex.exercise_name,wod.sets,wod.met_value,wod.reps,wod.youtube_link,wod.workout_image,wod.time,wod.rest FROM details_by_user dbu 
        //  INNER JOIN goals g ON (g.id = dbu.goal_id)
        //  INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
        //  INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
        //  INNER JOIN exercise ex ON (ex.id = wod.exercise_id AND ex.is_alternate IS NULL)
        //  INNER JOIN users us ON (us.id = dbu.user_id)

        //  WHERE dbu.is_cancelled = '0' and dbu.workout_day=".$new_work_out_day." AND dbu.user_id = ".$data['user_id'];exit;

        $total_workout_minutes = DB::select("SELECT concat(ROUND(SUM(wod.sets*((wod.time/60)+(wod.rest/60)))),' mins') AS total_minutes 
  FROM details_by_user dbu
  INNER JOIN goals g ON (g.id = dbu.goal_id)
  INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
  INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
  INNER JOIN exercise ex ON (ex.id = wod.exercise_id AND ex.is_alternate IS NULL)
  INNER JOIN users us ON (us.id = dbu.user_id)
  WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $workoutdaycount . " AND dbu.user_id = " . $data['user_id']);

        //echo json_encode($total_workout_minutes);exit;


        //      $veg_nutrition = DB::select("SELECT fo.nutrition_details_name,fo.calories,fo.quantity,fo.nutrition_image,fo.time_of_day FROM nutrition_details fo
        // INNER JOIN goals g ON (g.id = fo.goal_id)
        // INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        // INNER JOIN workout_schedule ws ON (ws.id = fo.workout_schedule_id)
        // INNER JOIN workout_type wt ON (wt.id = fo.workout_type_id)
        // WHERE fo.is_veg='Y' AND fo.status='0' AND fo.nutrition_day=1 AND fo.goal_id=".$data['goal_id']." AND fo.work_order_plan_id = ".$data['workout_plan_id']." AND fo.workout_schedule_id =".$data['workout_frequency_id']." AND fo.workout_type_id =".$data['workout_type_id']);


        //         $nonveg_nutrition = DB::select("SELECT fo.nutrition_details_name,fo.calories,fo.quantity,fo.nutrition_image,fo.time_of_day FROM nutrition_details fo
        // INNER JOIN goals g ON (g.id = fo.goal_id)
        // INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        // INNER JOIN workout_schedule ws ON (ws.id = fo.workout_schedule_id)
        // INNER JOIN workout_type wt ON (wt.id = fo.workout_type_id)
        // WHERE fo.is_nonveg='Y' AND fo.nutrition_day=1 and fo.status='0' AND fo.goal_id=".$data['goal_id']." AND fo.work_order_plan_id = ".$data['workout_plan_id']." AND fo.workout_schedule_id =".$data['workout_frequency_id']." AND fo.workout_type_id =".$data['workout_type_id']);






        $rows = [
          'Success' => "True",
          'work_out_plan_header' => $work_out_plan_header,
          'total_workout_minutes' => $total_workout_minutes,
          'work_out_plan_excercise' => $work_out_plan_excercise,


        ];
      }
      // \Log::info(json_encode($rows));
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function getexercisebyday(Request $request)
  {
    //return $request;

    try {

      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'workout_day' => $request->existing_workout_day,
        'workout_details_by_user_id' => $request->workout_details_by_user_id,
        'user_id' => $request->user_id,


      ];
      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'workout_details_by_user_id' => 'required',
        'workout_day' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        'workout_day.required' => 'Work Out Day is required',
        'workout_details_by_user_id.required' => 'Work Out Details By User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {


        DB::table('details_by_user')
          ->where('id', $data['workout_details_by_user_id'])
          ->update([
            'workout_status' => 'Completed',
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);

        // $reg_date=DB::select("SELECT distinct DATE_FORMAT(created_at, "%Y-%m-%d") AS reg_date FROM details_by_user WHERE user_id=".$data['user_id']);
        // $current_date=DB::select("SELECT CURDATE()");
        // $workout_daynew=DB::select("SELECT DATEDIFF("$reg_date", "$current_date") AS workout_day;")

        $workout_day = 1;
        $workout_daynew = $data['workout_day'];
        $new_work_out_day = $workout_day + $workout_daynew;


        $work_out_plan_header = DB::select("SELECT dbu.id as workout_details_by_user_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,
      dbu.workout_type_id,dbu.workout_day,dbu.user_id,g.goal_name,CONCAT('Day ',dbu.workout_day) AS workout_day_string,wop.work_out_plan_name,wop.work_out_plan_count AS work_out_plan_days FROM details_by_user dbu 
      INNER JOIN goals g ON (g.id = dbu.goal_id)
      INNER JOIN work_out_plan wop ON (wop.id = dbu.workout_plan_id)
      WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $new_work_out_day . " AND user_id=" . $data['user_id']);


        $work_out_plan_excercise = DB::select("SELECT dbue.id as details_by_user_exercize_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id,dbu.workout_day,dbu.user_id,g.goal_name,ex.id as exercise_id ,ex.exercise_name,wod.sets,wod.met_value,wod.reps,wod.youtube_link,wod.workout_image,wod.time,wod.rest FROM details_by_user dbu 
      INNER JOIN goals g ON (g.id = dbu.goal_id)
      INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
      INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
      INNER JOIN exercise ex ON (ex.id = wod.exercise_id AND ex.is_alternate IS NULL)
      INNER JOIN users us ON (us.id = dbu.user_id)
      WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $new_work_out_day . " AND dbu.user_id = " . $data['user_id']);


        $total_workout_minutes = DB::select("SELECT concat(ROUND(SUM(wod.sets*((wod.time/60)+(wod.rest/60)))),' mins') AS total_minutes FROM details_by_user dbu
      INNER JOIN goals g ON (g.id = dbu.goal_id)
      INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
      INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
      INNER JOIN exercise ex ON (ex.id = wod.exercise_id AND ex.is_alternate IS NULL)
      INNER JOIN users us ON (us.id = dbu.user_id)
      WHERE dbu.is_cancelled = '0' and dbu.workout_day=" . $new_work_out_day . " AND dbu.user_id = " . $data['user_id']);
        // $veg_nutrition = DB::select("SELECT fo.nutrition_details_name,fo.calories,fo.quantity,fo.nutrition_image,fo.time_of_day FROM nutrition_details fo
        //  INNER JOIN goals g ON (g.id = fo.goal_id)
        //  INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        //  INNER JOIN workout_schedule ws ON (ws.id = fo.workout_schedule_id)
        //  INNER JOIN workout_type wt ON (wt.id = fo.workout_type_id)
        //  WHERE fo.is_veg='Y' AND fo.status='0' AND fo.goal_id=".$data['goal_id']." AND fo.work_order_plan_id = ".$data['workout_plan_id']." AND fo.workout_schedule_id =".$data['workout_frequency_id']." AND fo.workout_type_id =".$data['workout_type_id']." and fo.nutrition_day=".$new_work_out_day);


        // $nonveg_nutrition = DB::select("SELECT fo.nutrition_details_name,fo.calories,fo.quantity,fo.nutrition_image,fo.time_of_day FROM nutrition_details fo
        //  INNER JOIN goals g ON (g.id = fo.goal_id)
        //  INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        //  INNER JOIN workout_schedule ws ON (ws.id = fo.workout_schedule_id)
        //  INNER JOIN workout_type wt ON (wt.id = fo.workout_type_id)
        //  WHERE fo.is_nonveg='Y' AND fo.status='0' AND fo.goal_id=".$data['goal_id']." AND fo.work_order_plan_id = ".$data['workout_plan_id']." AND fo.workout_schedule_id =".$data['workout_frequency_id']." AND fo.workout_type_id =".$data['workout_type_id']." and fo.nutrition_day=".$new_work_out_day);






        $rows = [
          'Success' => "True",

          'work_out_plan_header' => $work_out_plan_header,
          'total_workout_minutes' => $total_workout_minutes,
          'work_out_plan_excercise' => $work_out_plan_excercise,

        ];
      }
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function updateexercisebyuser(Request $request)
  {
    //return $request;
    //echo "string";exit();
    //echo json_encode($activeusercount) ;exit;
    try {

      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'workout_day' => $request->workout_day,
        'workout_details_by_user_id' => $request->workout_details_by_user_id,
        'user_id' => $request->user_id,
      ];
      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'workout_details_by_user_id' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        'workout_details_by_user_id.required' => 'Work Out Details By User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {


        $cummulativepoints = DB::select("SELECT SUM(case when dbue.points IS NULL then 0 ELSE dbue.points END) AS points ,round((SUM(case when dbue.calories IS NULL then 0 ELSE dbue.calories END)),2) calories,
     SUM(dbue.playedseconds) playedseconds,SUM(wod.time) AS actualpoint, ROUND(((SUM(dbue.playedseconds)/SUM(wod.time))*100),2) percentage, 
ROUND(((dbu.workout_day)/(wop.work_out_plan_count))*100) AS total_pointss FROM details_by_user dbu
        INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id)
        INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
        INNER JOIN work_out_plan wop ON (wop.id=dbu.workout_plan_id)
        WHERE dbu.workout_day = " . $data['workout_day'] . " AND dbu.user_id = " . $data['user_id'] . " GROUP BY dbu.workout_day,wop.work_out_plan_count");


        DB::table('details_by_user')
          ->where([['workout_day', $data['workout_day']], ['user_id', $data['user_id']]])
          ->update([
            'total_points' => $cummulativepoints[0]->total_pointss,
            'calories' => $cummulativepoints[0]->calories,
            'workout_status' => 'Completed',
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);

        DB::table('notifications')->insertGetId([
          'type' => 'Workout Completed',
          'latest' => '1',
          'name' => 'Today Workout Completed',
          'notifiable_type' => 'Today Workout Completed Successfully',
          'notifiable_id' => '1',
          'data' => 'Today Workout Completed',
          'notification_details_id' => $data['user_id'],
          'status' => 0,
          'created_by' => 1,
          'created_at' => NOW(),
          'updated_at' => NOW()

        ]);

        $activeusercount = DB::select("SELECT COUNT(*) AS total_count FROM active_by_user abu
        WHERE abu.user_id = " . $data['user_id'] . " ");

        $activeusercreateDate = DB::select("SELECT dbu.created_at AS created_at FROM details_by_user dbu
        WHERE dbu.is_cancelled=0 AND dbu.user_id = " . $data['user_id'] . " ");

        if ($activeusercount == 0) {

          DB::table('active_by_user')->insertGetId([
            'workout_frequency_id' => $data['workout_frequency_id'],
            'goal_id' => $data['goal_id'],
            'workout_plan_id' => $data['workout_plan_id'],
            'workout_type_id' => $data['workout_type_id'],
            'workout_day' => $data['workout_day'],
            'user_id' => $data['user_id'],
            'total_points' => $cummulativepoints[0]->total_pointss,
            'calories' => $cummulativepoints[0]->calories,
            'workout_status' => 'Completed',
            'status' => 0,
            'created_by' => 1,
            'created_at' => $activeusercreateDate[0]->created_at,
            'Workout_Completed_Date' => NOW()
          ]);
        } else {

          DB::table('active_by_user')
            ->where([['user_id', $data['user_id']]])
            ->update([
              'workout_frequency_id' => $data['workout_frequency_id'],
              'goal_id' => $data['goal_id'],
              'workout_plan_id' => $data['workout_plan_id'],
              'workout_type_id' => $data['workout_type_id'],
              'workout_day' => $data['workout_day'],
              'total_points' => $cummulativepoints[0]->total_pointss,
              'calories' => $cummulativepoints[0]->calories,
              'workout_status' => 'Completed',
              'status' => 0,
              'created_at' => $activeusercreateDate[0]->created_at,
              'updated_by' => $data['user_id'],
              'updated_at' => NOW()
            ]);
        }
      }

      //echo json_encode($cummulativepoints) ;exit;

      $daypointsandcalories = [
        'total_points' => $cummulativepoints[0]->total_pointss,
        'calories' => $cummulativepoints[0]->calories
      ];
      return $this->sendResponse($daypointsandcalories, "Day " . $data['workout_day'] . ' updated successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function getalternateexercisebyuser(Request $request)
  {
    //return $request;

    try {

      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'workout_day' => $request->workout_day,
        // 'workout_details_by_user_id' => $request->workout_details_by_user_id,
        'user_id' => $request->user_id,
        'exercise_id' => $request->exercise_id,


      ];
      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'workout_day' => 'required',
        'user_id' => 'required',
        'exercise_id' => 'required'
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        'workout_day.required' => 'Work Out Day is required',
        'exercise_id.required' => 'Exercise ID is required',

      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {



        $alternate_exercise = DB::select("SELECT dbue.id as details_by_user_exercize_id,dbu.workout_frequency_id,ex.id,ex.alternate_exercise,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id,dbu.workout_day,dbu.user_id,ex.exercise_name,wod.sets,wod.met_value,wod.reps,wod.workout_image,wod.youtube_link,wod.time,wod.rest,dbue.id AS alternate_exercise_id FROM details_by_user dbu
      INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id )
      INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id AND dbue.exercise_id =  wod.exercise_id)
      INNER JOIN exercise ex ON (ex.id = dbue.exercise_id)
      INNER JOIN users us ON (us.id = dbu.user_id)
      WHERE  dbu.is_cancelled = '0' and dbu.workout_day=" . $data['workout_day'] . " and dbu.user_id=" . $data['user_id'] . " AND ex.alternate_exercise =" . $data['exercise_id']);

        $rows = [
          'Success' => "True",
          'alternate_exercise' => $alternate_exercise,
        ];
      }
      return $rows;
      //return $this->sendResponse('Success', "Day ".$data['workout_day']. ' updated successfully.');               

    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function getalternateexercisebyuserbyid(Request $request)
  {
    try {
      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'workout_day' => $request->workout_day,
        'user_id' => $request->user_id,
        'exercise_id' => $request->exercise_id,
        'alternate_exercise_id' => $request->alternate_exercise_id,
      ];
      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'workout_day' => 'required',
        'user_id' => 'required',
        'exercise_id' => 'required',
        'alternate_exercise_id' => 'required'
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        'workout_day.required' => 'Work Out Day is required',
        'exercise_id.required' => 'Exercise ID is required',
        'alternate_exercise_id.required' => 'Alternate Exercise ID is required',

      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        $alternate_exercise = DB::select("SELECT dbue.id as details_by_user_exercize_id,dbu.workout_frequency_id,ex.id,ex.alternate_exercise,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id,dbu.workout_day,dbu.user_id,ex.exercise_name,wod.sets,wod.met_value,wod.reps,wod.workout_image,wod.youtube_link,wod.time,wod.rest FROM details_by_user dbu 
      INNER JOIN details_by_user_exercize dbue ON (dbue.details_by_user_id = dbu.id )
      INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id AND dbue.exercise_id =  wod.exercise_id)
      INNER JOIN exercise ex ON (ex.id = dbue.exercise_id)
      INNER JOIN users us ON (us.id = dbu.user_id)
      WHERE  dbu.is_cancelled = '0' and dbu.workout_day=" . $data['workout_day'] . " and dbu.user_id=" . $data['user_id'] . " AND ex.alternate_exercise =" . $data['exercise_id'] . " and dbue.id = " . $data['alternate_exercise_id']);

        $rows = [
          'Success' => "True",
          'alternate_exercise' => $alternate_exercise,
        ];
      }
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function cancelworkoutbyuser(Request $request)
  {
    try {

      $data = [
        'workout_frequency_id' => $request->workout_frequency_id,
        'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        'workout_type_id' => $request->workout_type_id,
        'user_id' => $request->user_id
      ];
      $rules = [

        'workout_frequency_id' => 'required',
        'goal_id' => 'required',
        'workout_plan_id' => 'required',
        'workout_type_id' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        'workout_frequency_id.required' => 'Work Out Frequency is required',
        'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        DB::table('details_by_user')
          ->where('workout_plan_id', $data['workout_plan_id'])
          ->update([
            'is_cancelled' => '1',
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);

        DB::table('user_details')
          ->where('user_id', $data['user_id'])
          ->update([
            'cancel_plan_Status' => '1'
          ]);

        //   $Workoutplan_Cancellog = DB::select("SELECT first_name,created_at FROM `user_details` WHERE user_id=".$data['user_id']);


        //       DB::table('cancel_plan_log')->insertGetId([
        //       'user_id' => $data['user_id'],
        //       'workout_type_id' => $data['workout_type_id'],
        //       'workout_plan_id' => $data['workout_plan_id'],
        //       'goal_id' => $data['goal_id'],
        //       'workout_frequency_id' => $data['workout_frequency_id'],
        //       'user_name'=>$data['user_id'],
        //       'registered_date'=>$data['user_id'],
        //       'plan_selected' => $data['user_id'],
        //       'date_of_workout_start' => 0,
        //       'plan_cancel_date' => NOW()
        //     ]);


        DB::delete("DELETE from details_by_user where is_cancelled='1' AND user_id =" . $data['user_id']);
      }
      return $this->sendResponse('Success', 'Workout Plan Cancelled successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  //DeleteAccount
  public function deleteaccount(Request $request)
  {
    try {
      //echo "string";exit;
      $data = [

        'user_id' => $request->user_id
      ];
      $rules = [

        'user_id' => 'required',
      ];
      $messages = [

        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      //echo json_encode($data['user_id']);exit;

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        DB::table('users')
          ->where('id', $data['user_id'])
          ->update([
            'status' => '1',
            'deleted_by' => $data['user_id'],
            'deleted_at' => NOW()
          ]);

        DB::table('user_details')
          ->where('user_id', $data['user_id'])
          ->update([
            'status' => '1',
            'deleted_by' => $data['user_id'],
            'deleted_at' => NOW()
          ]);

        DB::table('details_by_user')
          ->where('user_id', $data['user_id'])
          ->update([
            'status' => '1',
            'deleted_by' => $data['user_id'],
            'deleted_at' => NOW()
          ]);

        //  $id = $data['user_id'];

        //  DB::delete("delete from users where id = '$id'");

        //  DB::delete("delete from user_details where user_id = '$id'");

        //  DB::delete("delete from details_by_user where user_id = '$id'");
      }
      return $this->sendResponse('Success', 'Account delete successfully.kindly register again.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function feedback(Request $request)
  {
    //return $request;

    try {

      $data = [
        'feeback_name' => $request->feeback_name,
        'user_id' => $request->user_id
      ];
      $rules = [

        'user_id' => 'required',
        'feeback_name' => 'required ',
      ];
      $messages = [

        'user_id.required' => 'User ID is required',
        'feeback_name.required' => 'Feedback Name is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {



        // DB::transaction(function() use($data){
        $feedback = DB::table('feeback_master')->insertGetId([

          'feeback_name' => $data['feeback_name'],
          'user_id' => $data['user_id'],
          'status' => 0,
          'created_by' => 1,
          'created_at' => NOW()
        ]);

        $this->sendAuditLog('feedback', $feedback, 'Create', 'Create Feedback Details', 1, NOW());
        // }); 

        $mailid = "thefzoneorg@gmail.com";

        $data = [
          'feeback_name' => $data['feeback_name']
        ];

        //echo json_encode($data['feeback_name']) ;exit;

        // Mail::to($mailid)->send(new SendMailSupport($data));


      }
      return $this->sendResponse('Success', 'Message sent successfully.Thank you for your feedback');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function workout_feedback(Request $request)
  {
    //return $request;

    try {

      $data = [
        'feeback_name' => $request->feeback_name,

        'feedback_description' => $request->feedback_description,
        'user_id' => $request->user_id,

      ];
      $rules = [

        'user_id' => 'required',
        'feeback_name' => 'required ',
        'feedback_description' => 'required ',
      ];
      $messages = [

        'user_id.required' => 'User ID is required',
        'feeback_name.required' => 'Feedback Name is required',
        'feedback_description.required' => 'Feedback Description is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {



        // DB::transaction(function() use($data){
        $feedback = DB::table('workout_feeback')->insertGetId([

          'feeback_name' => $data['feeback_name'],
          'user_id' => $data['user_id'],
          'feedback_description' => $data['feedback_description'],
          'status' => 0,
          'created_by' => 1,
          'created_at' => NOW()
        ]);

        $this->sendAuditLog('feedback', $feedback, 'Create', 'Create Feedback Details', 1, NOW());
        // }); 


      }
      return $this->sendResponse('Success', 'Workout Feedback by the User Saved Successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function getpersoneldetails(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id


      ];
      $rules = [
        'user_id' => 'required',
      ];
      $messages = [
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        $personel_details = DB::select("SELECT ud.user_id,us.name,ud.gender,ud.age,ud.activitylevel,ud.medicalcondition,ud.height,ud.weight FROM users AS us INNER JOIN user_details ud ON (ud.user_id =us.id) where user_id=" . $data['user_id']);
      }
      return $personel_details;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function updatepersoneldetails(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id,
        'first_name' => $request->name,
        'gender' => $request->gender,
        'age' => $request->age,
        'activitylevel' => $request->activitylevel,
        'medicalcondition' => $request->medicalcondition
      ];
      $rules = [

        'first_name' => 'required',
        'age' => 'required',
        'gender' => 'required',
        'user_id' => 'required',
        'activitylevel' => 'required',
        'medicalcondition' => 'required',

      ];

      $messages =
        [
          'first_name.required' => 'User Name is required',
          'age.required' => 'Age is required',
          'gender.required' => 'Gender is required',
          'user_id.required' => 'User ID is required',
          'first_name.unique' => 'User Name is Already Exist',
          'medicalcondition.required' => 'Medical Condition is required',
          'activitylevel.required' => 'Activity Level is required',
        ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {


        DB::table('users')
          ->where('id',  $data['user_id'])
          ->update([
            'name' => $data['first_name'],



            //  'user_image' => $data['user_image'],                                           
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);


        DB::table('user_details')
          ->where('user_id',  $data['user_id'])
          ->update([
            'first_name' => $data['first_name'],


            'gender' => $data['gender'],
            'activitylevel' => $data['activitylevel'],
            'medicalcondition' => $data['medicalcondition'],

            'age' => $data['age'],
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);
      }
      return $this->sendResponse('Success',  'Personal Details updated successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function getprofiledetails(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id


      ];
      $rules = [
        'user_id' => 'required',
      ];
      $messages = [
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        $profile_details = DB::select("SELECT us.name,ud.address,us.email,ud.profile_image FROM users AS us INNER JOIN user_details ud ON (ud.user_id =us.id) where user_id=" . $data['user_id']);
      }
      return $profile_details;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  //Mobile
  public function getMobileprofiledetails(Request $request)
  {

    try {

      $data = [
        'mobile_no' => $request->mobile_no


      ];
      $rules = [
        'mobile_no' => 'required',
      ];
      $messages = [
        'mobile_no.required' => 'Mobile Number is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        $Mob_profile_count = DB::select("SELECT ud.user_id,us.name,us.email,ud.mobile_no,ud.gender,ud.age,ud.height,ud.weight,ud.activitylevel,ud.medicalcondition,ud.address,ud.profile_image FROM users AS us 
                                         INNER JOIN user_details ud ON (ud.user_id =us.id) 
                                         where ud.status='0' AND mobile_no=" . $data['mobile_no'] . " GROUP BY ud.user_id,us.name,us.email,ud.mobile_no,ud.gender,ud.age,ud.height,
                                        ud.weight,ud.activitylevel,ud.medicalcondition,ud.address,ud.profile_image");

        $Mob_profile_details = DB::select("SELECT dbu.user_id,dbu.goal_id,dbu.workout_frequency_id,dbu.workout_plan_id,dbu.workout_type_id, us.name,us.email,ud.mobile_no,ud.gender,ud.age,ud.height,
                                        ud.weight,ud.activitylevel,ud.medicalcondition,ud.address,ud.profile_image FROM users AS us 
                                         INNER JOIN user_details ud ON (ud.user_id =us.id) 
                                         INNER JOIN details_by_user dbu on (dbu.user_id=us.id) 
                                         where ud.status='0' AND mobile_no=" . $data['mobile_no'] . " GROUP BY dbu.user_id,dbu.goal_id,dbu.workout_frequency_id,dbu.workout_plan_id,dbu.workout_type_id, us.name,us.email,ud.mobile_no,ud.gender,ud.age,ud.height,
                                        ud.weight,ud.activitylevel,ud.medicalcondition,ud.address,ud.profile_image");

        $rows = [
          'Success' => "True",
          'Mob_profile_count' => $Mob_profile_count,
          'Mob_profile_details' => $Mob_profile_details,
        ];
      }
      return $rows;

      //return $Mob_profile_details;

    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  //getworkoutplanexit
  public function getworkoutplanexit(Request $request)
  {

    try {

      $data = [
        'mobile_no' => $request->mobile_no


      ];
      $rules = [
        'mobile_no' => 'required',
      ];
      $messages = [
        'mobile_no.required' => 'Mobile Number is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        $workoutplanexit_count = DB::select("SELECT us.name,ud.address,us.email,ud.mobile_no,ud.profile_image,dbu.is_cancelled,dbu.user_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id  
       FROM users AS us INNER JOIN user_details ud ON (ud.user_id =us.id) INNER JOIN details_by_user dbu ON (dbu.user_id=us.id) where ud.status='0' AND dbu.is_cancelled='0' AND mobile_no=" . $data['mobile_no']);

        $workoutplancomplete_count = DB::select("SELECT us.name,ud.address,us.email,ud.mobile_no,ud.profile_image,dbu.is_cancelled,dbu.user_id,dbu.workout_frequency_id,dbu.goal_id,dbu.workout_plan_id,dbu.workout_type_id  
       FROM users AS us INNER JOIN user_details ud ON (ud.user_id =us.id) INNER JOIN details_by_user dbu ON (dbu.user_id=us.id) where ud.status='0' AND dbu.is_cancelled='0' AND dbu.Workout_Date=DATE_FORMAT(NOW(),'%Y-%m-%d') AND mobile_no=" . $data['mobile_no']);

        $rows = [
          'Success' => "True",
          'workoutplanexit_count' => $workoutplanexit_count,
          'workoutplancomplete_count' => $workoutplancomplete_count,
        ];
      }
      return $rows;
      //return $workoutplanexit_count;

    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  //OTP
  public function generatedotp(Request $request)
  {

    try {
      $method = 'Method => MobileAPIController => Generatedotp';
      $inputArray = $this->decryptData($request->requestData);

      $mobilenumber = $inputArray['mobile_no'];
      $email =  $inputArray['email_otp'];

      // $checknum = DB::table('users')->where('mobile_no', '=', $mobilenumber)->orWhere('email', '=', $email)->first();

      $checknum = DB::table('users')->where('email', '=', $email)->first();

      if ($checknum == null) {
        $serviceResponse = array();
        $serviceResponse['Code'] = 404;
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
      } else {
        $otp = rand(1000, 9999);
        DB::table('users')
          ->where('email', $email)
          ->update(['otp' => $otp]);
      }

      $data = array(
        'otp' => $otp,
        'name' => $checknum->name,
      );

      Mail::to($checknum->email)->send(new OTPMail($data));

      // $mobile_no = $mobilenumber['mobilenumber'];
      // $api_key = '36020BEA07BE0F';
      // $contacts = $mobile_no;
      // $from = 'TFZIND';
      // $sms_text = "Greetings from TFZIND. Mobile verification OTP " . $otp;

      // $ch = curl_init();
      // curl_setopt($ch, CURLOPT_URL, "http://crb.net.in/app/smsapi/index.php");
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($ch, CURLOPT_POST, 1);
      // curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=4&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text);
      // $response = curl_exec($ch);

      // $url = "http://crb.net.in/app/smsapi/index.php?key=" . $api_key . "&campaign=0&routeid=4&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text;

      // $ch = curl_init();
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_URL, $url);
      // $result = curl_exec($ch);
      // $ret = 0;
      // if (strstr($result, "accepted")) {
      //   $ret = 1;
      // }
      // $ret = 1;

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
  //Verify OTP
  public function verifyotp(Request $request)
  {
    try {
      $method = 'Method => MobileApiController => Verifyotp';

      $inputArray = $this->decryptData($request->requestData);

      $data = [
        'mobile_no' => $inputArray['mobile_no'],
        'otp' => $inputArray['otp'],
        'email' => $inputArray['email_otp'],
      ];

      $email =  $data['email'];

      $Verify_otp = DB::select("SELECT mobile_no from users where email='$email'");

      if ($Verify_otp == null) {
        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.not_exist');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
      }
      $Verify_otp = DB::select("SELECT id,password from users where email='$email' and otp=" . $data['otp']);

      if ($Verify_otp !== []) {

        $response = $Verify_otp;
        $responses = json_decode(json_encode($response), true);
        $responsedata['Data'] =  $responses;
        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $responsedata['Data'];
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

      } else {

        // $this->WriteFileLog("incorrectotp");
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

  //Resend OTP
  public function resendotp(Request $request)
  {
    $data = [
      'mobile_no' => $request->mobile_no,



    ];
    $rules = [
      'mobile_no' => 'required',

    ];
    $messages = [
      'mobile_no.required' => 'Mobile Number is required',

    ];

    $validator = Validator::make($data, $rules, $messages);
    //echo json_encode($mobilenumber) ;exit;


    $Resend_otp = DB::select("SELECT otp_id,mobile_no,otp,created_at,updated_at from otp_verification where mobile_no=" . $data['mobile_no']);

    $otp_Resend = $Resend_otp[0]->otp;
    //echo $otp_Resend;exit;
    //$this->Sample($mobilenumber);

    $mobile_no = $data['mobile_no'];
    //echo $mobile_no; exit;


    $api_key = '36020BEA07BE0F';
    $contacts = $mobile_no;
    $from = 'TFZIND';
    //$otp = rand(1000,9999);
    $sms_text = "Greetings from TFZIND. Mobile verification OTP " . $otp_Resend;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://crb.net.in/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=0&routeid=4&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text);
    $response = curl_exec($ch);

    //   $url = "http://crb.net.in/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=4&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;

    //   echo $url;exit;

    //   $ch = curl_init();   
    //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
    //   curl_setopt($ch, CURLOPT_URL, $url); 
    //   $result = curl_exec($ch); 
    //   $ret = 0;
    //   if(strstr($result, "accepted")) {$ret =1;}
    //   $ret =1;

    return $this->sendResponse('Success',  ' Resend OTP Send successfully.');
  }



  public function updateprofiledetails(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id,

        'first_name' => $request->name,

        'address' => $request->address,

        'email' => $request->email,

        'profile_image' => $request->profile_image

      ];
      $rules = [
        'user_id' => 'required',
        'first_name' => 'required',
        'address' => 'required',
        'email' => 'required',
      ];
      $messages = [
        'user_id.required' => 'User ID is required',
        'first_name.required' => 'First Name is required',
        'address.required' => 'Address is required',
        'email.required' => 'Email is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {


        DB::table('users')
          ->where('id',  $data['user_id'])
          ->update([
            'name' => $data['first_name'],
            'email' => $data['email'],
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);


        DB::table('user_details')
          ->where('user_id',  $data['user_id'])
          ->update([
            'first_name' => $data['first_name'],
            'address' => $data['address'],
            'profile_image' => $data['profile_image'],
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);
      }
      return $this->sendResponse('Success',  'Profile Details updated successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function global_leaderboard(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id


      ];
      $rules = [
        //'first_name' => 'required |unique:user_details,first_name', 
      ];
      $messages = [
        //'first_name.required' => 'First Name is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        //   echo 

        // SELECT (case when de.calories IS NULL then 0 ELSE de.calories END) calories ,
        // (case when de.total_points IS NULL then 0 ELSE de.total_points END) AS total_points,
        // CONCAT('Day ',de.workout_day) AS workout_day_string,us.first_name,us.profile_image FROM details_by_user de 
        // INNER JOIN user_details us ON (us.user_id = de.user_id) 
        // where us.user_id=".$data['user_id'] AND de.workout_status = 'Completed'

        $profile_details = DB::select("SELECT (case when de.calories IS NULL then 0 ELSE de.calories END) calories ,
        (case when de.total_points IS NULL then 0 ELSE de.total_points END) AS total_points,
        CONCAT('Day ',de.workout_day) AS workout_day_string,us.first_name,us.profile_image FROM details_by_user de 
        INNER JOIN user_details us ON (us.user_id = de.user_id) 
        where us.user_id=" . $data['user_id'] . " AND de.workout_status = 'Completed'");

        //       $profile_details = DB::select("SELECT (case when de.calories IS NULL then 0 ELSE de.calories END) calories ,
        // (case when de.total_points IS NULL then 0 ELSE de.total_points END) AS total_points,
        // CONCAT('Day ',de.workout_day) AS workout_day_string,us.first_name,us.profile_image FROM details_by_user de 
        // INNER JOIN user_details us ON (us.user_id = de.user_id) 
        // where us.user_id=".$data['user_id']);
        //     }
        return $profile_details;
      }
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function nutrition_dayone(Request $request)
  {
    //return $request;

    try {

      $data = [
        // 'workout_frequency_id' => $request->workout_frequency_id,
        // 'goal_id' => $request->goal_id,

        'workout_plan_id' => $request->workout_plan_id,
        // 'workout_type_id' => $request->workout_type_id,
        'user_id' => $request->user_id,


      ];
      $rules = [

        // 'workout_frequency_id' => 'required', 
        // 'goal_id' => 'required', 
        'workout_plan_id' => 'required',
        //'workout_type_id' => 'required',
        //'workout_details_by_user_id' => 'required', 
        //'workout_day' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        // 'workout_frequency_id.required' => 'Work Out Frequency is required',
        // 'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        //'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        //'workout_day.required' => 'Work Out Day is required',
        //'workout_details_by_user_id.required' => 'Work Out Details By User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        $reg_date1 = DB::select("SELECT distinct DATE_FORMAT(created_at, '%Y-%m-%d') AS reg_date FROM details_by_user WHERE user_id=" . $data['user_id']);
        $current_date1 = DB::select("SELECT CURDATE() as curr_date");
        $current_date = $current_date1[0]->curr_date;
        $reg_date = $reg_date1[0]->reg_date;

        $workout_daynew1 = DB::select("SELECT DATEDIFF( '$current_date','$reg_date') AS workout_day");
        $workout_daynew = $workout_daynew1[0]->workout_day;

        $workout_day = 1;
        // $workout_daynew = $data['workout_day'];
        $new_work_out_day = $workout_day + $workout_daynew;

        $work_out_day_count = DB::table('details_by_user')
          ->where([[DB::raw("(DATE_FORMAT(Workout_Date,'%Y-%m-%d'))"), NOW()->format('Y-m-d')], ['user_id', $data['user_id']]])
          ->select('Workout_Day')
          ->get();

        $workoutdaycount = $work_out_day_count[0]->Workout_Day;


        $details = DB::select("SELECT ud.age,ud.bmi,ud.bmr,ud.activitylevel,al.multiplication_factor FROM  user_details ud   INNER JOIN activity_level al ON (al.activity_name = ud.activitylevel) where user_id=" . $data['user_id']);
        $goal = DB::select("SELECT distinct ga.goal_name,ga.caloric_parameter,db.goal_id FROM details_by_user db INNER JOIN goals ga ON (ga.id = db.goal_id) WHERE user_id=" . $data['user_id']);
        $workout_type = DB::select("SELECT distinct wt.workout_type_name,db.workout_type_id,db.workout_day FROM details_by_user db INNER JOIN workout_type wt ON (wt.id = db.workout_type_id) WHERE user_id=" . $data['user_id']);
        $total_calories_day = DB::select("SELECT (case when calories IS NULL then 0 ELSE calories END) as calories,CONCAT('Day ',workout_day) AS food_day_string FROM details_by_user where workout_day=" . $workoutdaycount . " and  user_id=" . $data['user_id']);
        //dd ($total_calories);

        $bmr = $details[0]->bmr;
        $multiplication_factor = $details[0]->multiplication_factor;
        $calories_req = $bmr *  $multiplication_factor;
        $total_calories = $total_calories_day[0]->calories;

        if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Beginner")) {
          $calories_consume = round(($calories_req +  $total_calories - 300), 2);
        } else if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Intermediate")) {
          $calories_consume = round(($calories_req +  $total_calories - 400), 2);
        } else if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Advanced")) {
          $calories_consume = round(($calories_req +  $total_calories - 500), 2);
        }
        if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Beginner")) {
          $calories_consume = round(($calories_req +  $total_calories + 300), 2);
        } else if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Intermediate")) {
          $calories_consume = round(($calories_req +  $total_calories + 400), 2);
        } else if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Advanced")) {
          $calories_consume = round(($calories_req +  $total_calories + 500), 2);
        } else if (($goal[0]->goal_name == "Improve Flexibility")) {
          $calories_consume = round(($calories_req), 2);
        } else if (($goal[0]->goal_name == "Senior Citizen Fitness")) {
          $calories_consume = round(($calories_req), 2);
        }
        //echo($calories_consume);exit;






        $veg_nutrition = DB::select("SELECT fo.nutrition_details_name,round(((fo.calories_percentage / 100)* " . $calories_consume . "),2) AS calories,round(((((fo.calories_percentage / 100)* " . $calories_consume . ")* fo.quantity)/fo.calories),2) AS quantity,fo.food_url,fo.time_of_day, case WHEN fo.nutrition_details_name = 'Hot Cinnamon water' OR fo.nutrition_details_name = 'Milk (ml)'  THEN 'ml'
        ELSE 'gm' END AS quantity_parameter FROM nutrition_details fo
        INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        WHERE fo.is_veg='Y' AND fo.status='0' and fo.work_order_plan_id = " . $data['workout_plan_id'] . " and fo.nutrition_day=" . $workoutdaycount);


        $nonveg_nutrition = DB::select("SELECT fo.nutrition_details_name,round(((fo.calories_percentage / 100)* " . $calories_consume . "),2) AS calories,round(((((fo.calories_percentage / 100) * " . $calories_consume . ")* fo.quantity)/fo.calories),2) AS quantity,fo.food_url,fo.time_of_day,case WHEN fo.nutrition_details_name = 'Hot Cinnamon water' OR fo.nutrition_details_name = 'Milk (ml)'  THEN 'ml'
        ELSE 'gm' END AS quantity_parameter FROM nutrition_details fo
        INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
        WHERE fo.is_nonveg='Y' and fo.status='0' AND fo.work_order_plan_id = " . $data['workout_plan_id'] . " and fo.nutrition_day=" . $workoutdaycount);



        //dd($total_calories);


        $rows = [
          'Success' => "True",

          'veg_nutrition' => $veg_nutrition,
          'nonveg_nutrition' => $nonveg_nutrition,
          'food_details' => [
            'calories_consume' => $calories_consume,
            'caloric_parameter' => $goal[0]->caloric_parameter,
            'goal' => $goal[0]->goal_name,
            'day' => $total_calories_day[0]->food_day_string
          ]

        ];
      }
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function getnutritionbyday(Request $request)
  {
    //return $request;

    try {

      $data = [
        // 'workout_frequency_id' => $request->workout_frequency_id,
        // 'goal_id' => $request->goal_id,
        'workout_plan_id' => $request->workout_plan_id,
        //'workout_type_id' => $request->workout_type_id,
        'existing_workout_day' => $request->existing_workout_day,
        'user_id' => $request->user_id,


      ];
      $rules = [

        //'workout_frequency_id' => 'required', 
        //'goal_id' => 'required', 
        'workout_plan_id' => 'required',
        //'workout_type_id' => 'required',
        'existing_workout_day' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        //'workout_frequency_id.required' => 'Work Out Frequency is required',
        //'goal_id.required' => 'Goal is required',
        'workout_plan_id.required' => 'Work Out Plan is required',
        //'workout_type_id.required' => 'Work out Type is required',
        'user_id.required' => 'User ID is required',
        'existing_workout_day.required' => 'Existing Work Out Day is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        $workout_day = 1;
        $workout_daynew = $data['existing_workout_day'];
        $new_work_out_day = $workout_day + $workout_daynew;



        $details = DB::select("SELECT ud.age,ud.bmi,ud.bmr,ud.activitylevel,al.multiplication_factor FROM  user_details ud   INNER JOIN activity_level al ON (al.activity_name = ud.activitylevel) where user_id=" . $data['user_id']);
        $goal = DB::select("SELECT distinct ga.goal_name,ga.caloric_parameter,db.goal_id FROM details_by_user db INNER JOIN goals ga ON (ga.id = db.goal_id) WHERE user_id=" . $data['user_id']);
        $workout_type = DB::select("SELECT distinct wt.workout_type_name,db.workout_type_id,db.workout_day FROM details_by_user db INNER JOIN workout_type wt ON (wt.id = db.workout_type_id) WHERE user_id=" . $data['user_id']);
        $total_calories_day = DB::select("SELECT (case when calories IS NULL then 0 ELSE calories END) as calories,CONCAT('Day ',workout_day) AS food_day_string FROM details_by_user WHERE workout_day=" . $new_work_out_day . " and  user_id=" . $data['user_id']);

        $bmr = $details[0]->bmr;
        $multiplication_factor = $details[0]->multiplication_factor;
        $calories_req = $bmr *  $multiplication_factor;
        $total_calories = $total_calories_day[0]->calories;
        // echo json_encode($total_calories_day);exit;

        if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Beginner")) {
          $calories_consume = round(($calories_req +  $total_calories - 300), 2);
        } else if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Intermediate")) {
          $calories_consume = round(($calories_req +  $total_calories - 400), 2);
        } else if (($goal[0]->goal_name == "Lose Fat") && ($workout_type[0]->workout_type_name == "Advanced")) {
          $calories_consume = round(($calories_req +  $total_calories - 500), 2);
        }
        if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Beginner")) {
          $calories_consume = round(($calories_req +  $total_calories + 300), 2);
        } else if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Intermediate")) {
          $calories_consume = round(($calories_req +  $total_calories + 400), 2);
        } else if (($goal[0]->goal_name == "Gain Muscle") && ($workout_type[0]->workout_type_name == "Advanced")) {
          $calories_consume = round(($calories_req +  $total_calories + 500), 2);
        } else if (($goal[0]->goal_name == "Improve Flexibility")) {
          $calories_consume = round(($calories_req), 2);
        } else if (($goal[0]->goal_name == "Senior Citizen Fitness")) {
          $calories_consume = round(($calories_req), 2);
        }


        $veg_nutrition = DB::select("SELECT fo.nutrition_details_name,round(((fo.calories_percentage / 100)* " . $calories_consume . "),2) AS calories,round(((((fo.calories_percentage / 100)* " . $calories_consume . ")* fo.quantity)/fo.calories),2) AS quantity,fo.food_url,fo.time_of_day, case WHEN fo.nutrition_details_name = 'Hot Cinnamon water' OR fo.nutrition_details_name = 'Milk (ml)'  THEN 'ml'
      ELSE 'gm' END AS quantity_parameter FROM nutrition_details fo
      INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
      WHERE fo.is_veg='Y' AND fo.status='0' AND fo.work_order_plan_id = " . $data['workout_plan_id'] . " and fo.nutrition_day=" . $new_work_out_day);


        $nonveg_nutrition = DB::select("SELECT fo.nutrition_details_name,round(((fo.calories_percentage / 100)* " . $calories_consume . "),2) AS calories,round(((((fo.calories_percentage / 100)* " . $calories_consume . ")* fo.quantity)/fo.calories),2) AS quantity,fo.food_url,fo.time_of_day, case WHEN fo.nutrition_details_name = 'Hot Cinnamon water' OR fo.nutrition_details_name = 'Milk (ml)'  THEN 'ml'
      ELSE 'gm' END AS quantity_parameter FROM nutrition_details fo
      INNER JOIN work_out_plan wop ON (wop.id = fo.work_order_plan_id)
      WHERE fo.is_nonveg='Y'  and fo.status='0' AND fo.work_order_plan_id = " . $data['workout_plan_id'] . " and fo.nutrition_day=" . $new_work_out_day);






        $rows = [
          'Success' => "True",

          'veg_nutrition' => $veg_nutrition,
          'nonveg_nutrition' => $nonveg_nutrition,
          'food_details' => [
            'calories_consume' => $calories_consume,
            'caloric_parameter' => $goal[0]->caloric_parameter,
            'goal' => $goal[0]->goal_name,
            'day' => $total_calories_day[0]->food_day_string
          ]
        ];
      }
      return $rows;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function workouttype(Request $request)
  {
    try {

      $data = [
        'user_id' => $request->user_id


      ];
      $rules = [
        'user_id' => 'required',
      ];
      $messages = [
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {
        $age = DB::select("SELECT ud.age FROM  user_details ud  where user_id=" . $data['user_id']);
        //dd($age[0]->age);
        $user_age = $age[0]->age;
        $workout_type = DB::select("select wt.id, wt.workout_type_name FROM workout_type wt 
        WHERE $user_age between wt.age_from AND wt.age_to and wt.status=0 order by order_by asc");
      }
      return $workout_type;
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }




  public function updateexercisedetailsbyuser(Request $request)
  {
    //return $request;

    try {

      $data = [
        'details_by_user_exercize_id' => $request->details_by_user_exercize_id,
        'seconds' => $request->seconds,
        'user_id' => $request->user_id,
      ];

      $rules = [

        'details_by_user_exercize_id' => 'required',
        'seconds' => 'required',
        'user_id' => 'required',
      ];
      $messages = [

        'details_by_user_exercize_id.required' => 'Details by User ID is required',
        'seconds.required' => 'Seconds is required',
        'user_id.required' => 'User ID is required',
      ];

      $validator = Validator::make($data, $rules, $messages);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors(), 400);
      } else {

        // echo "SELECT wod.sets,wod.met_value,wod.time,(".$data['seconds']."/wod.time) AS points,
        //   ((wod.met_value * ud.weight) * (".$data['seconds']."/360)) + ((wod.met_value * ud.weight) * ((wod.sets * wod.reps * 1.4)/3660)) AS calories
        //   FROM details_by_user_exercize dbue
        //   INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
        //   INNER JOIN user_details ud on (ud.user_id = dbue.user_id) 
        //   WHERE dbue.id=".$data['details_by_user_exercize_id']; exit;
        //Final Formula = MET Value * Body weight * (mins/60) + MET Value * Body weight * (set * reps * 1.4) / (3660)
        $rows = DB::select("SELECT wod.sets,wod.met_value,wod.time,(" . $data['seconds'] . "/wod.time) AS points,
        ((wod.met_value * ud.weight) * (" . $data['seconds'] . "/360)) + ((wod.met_value * ud.weight) * ((wod.sets * wod.reps * 1.4)/3660)) AS calories
        FROM details_by_user_exercize dbue
        INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
        INNER JOIN user_details ud on (ud.user_id = dbue.user_id) 
        WHERE dbue.exercise_id=" . $data['details_by_user_exercize_id'] . " AND dbue.user_id=" . $data['user_id']);

        //echo  count($rows); exit;

        if (count($rows) == 0) {
          $rows = DB::select("SELECT wod.sets,wod.met_value,wod.time,(" . $data['seconds'] . "/wod.time) AS points,
        ((wod.met_value * ud.weight) * (" . $data['seconds'] . "/360)) + ((wod.met_value * ud.weight) * ((wod.sets * wod.reps * 1.4)/3660)) AS calories
        FROM details_by_user_exercize dbue
        INNER JOIN work_out_details wod ON (wod.id = dbue.work_out_details_id)
        INNER JOIN user_details ud on (ud.user_id = dbue.user_id) 
        WHERE dbue.user_id=" . $data['user_id']);

          //echo "test"; exit();

        }

        DB::table('details_by_user_exercize')
          ->where('exercise_id', $data['details_by_user_exercize_id'])
          ->update([
            'points' => $rows[0]->points,
            'calories' => $rows[0]->calories,
            'playedseconds' => $data['seconds'],
            'updated_by' => $data['user_id'],
            'updated_at' => NOW()
          ]);
      }
      return $this->sendResponse('Success', 'Exercise Details updated successfully.');
    } catch (\Exception $exc) {
      return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  // public function calories_per_exercise(Request $request){
  //       //return $request;

  //   try{

  //     $data = [
  //       'workout_frequency_id' => $request->workout_frequency_id,
  //       'goal_id' => $request->goal_id,
  //       'workout_plan_id' => $request->workout_plan_id,
  //       'workout_type_id' => $request->workout_type_id,
  //       'details_by_user_id' => $request->details_by_user_id,
  //       'user_id' => $request->user_id,
  //       'exercise_sec'=> $request->exercise_sec,


  //     ];
  //     $rules = [

  //       //'first_name' => 'required |unique:user_details,first_name', 
  //     ];
  //     $messages = [

  //       //'first_name.required' => 'First Name is required',
  //     ];
  //     $work_out_details=DB::select("SELECT * FROM work_out_details where workout_schedule_id =" .$data['workout_frequency_id'] . " and goal_id = " .$data['goal_id']. " and work_order_plan_id = ".$data['workout_plan_id'] . " and workout_type_id = ".$data['workout_type_id']);

  //         $sets=$work_out_details[0]->sets;
  //         $reps=$work_out_details[0]->reps;
  //         $met_value=$work_out_details[0]->met_value;
  //         $exercise_sec =$data['exercise_sec'];
  //         $minutes=$exercise_sec / 60;



  //         $weight=DB::select("SELECT ud.weight FROM  user_details ud  where user_id=".$data['user_id']);
  //         $userweight=$weight[0]->weight;

  //         $calories_per_ex = $met_value * $userweight * ($minutes /60) + $met_value * $userweight * ($sets * $reps * 1.4) / (3660);

  //         //echo $calories_per_ex; exit;

  //     $validator = Validator::make($data, $rules, $messages);

  //     if($validator->fails()){
  //       return $this->sendError('Validation Error.', $validator->errors(), 400);
  //     }else
  //     {


  //      DB::table('details_by_user_exercize')
  //      ->where('id', $data['details_by_user_id'])
  //      ->update([
  //       'calories' => $calories_per_ex,                        
  //       'updated_by' => $data['user_id'],
  //       'updated_at' => NOW()
  //     ]);


  //    }
  //    return $this->sendResponse('Success',  ' updated successfully.');               

  //  }catch(\Exception $exc){
  //   return $this->sendLog('Method => MobileAPIController => store', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
  // }
  // }






}
