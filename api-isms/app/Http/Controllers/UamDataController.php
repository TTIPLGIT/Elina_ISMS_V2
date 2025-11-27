<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;


class UamDataController extends BaseController
{

    public function menu_data(Request $request)
    {
        try {
            $method = 'Method => UamDataController => menu_data';
            
            $user_id =  auth()->user()->id;
            $user_id1 = DB::select("select * from uam_user_roles where user_id=$user_id");
            $user_role = $user_id1[0]->role_id;
            $role = DB::select("select * from uam_roles WHERE role_id=$user_role");
            
            $additional = DB::Select("SELECT CASE WHEN roles IS NULL THEN array_roles ELSE CONCAT(array_roles, ',', roles) END AS rolesArray
            FROM users WHERE id = $user_id");
            $role_id = $additional[0]->rolesArray;
            // $this->WriteFileLog($role_id);
            // $modules ['data']= DB::select("select DISTINCT a.module_id,b.class_name, b.module_name,a.user_id from uam_user_screens as a inner join uam_modules as b on b.module_id = a.module_id where a.user_id = $user_id");

            $screens['screens'] = DB::select("select a.route_url,a.screen_id,a.screen_name,a.module_id AS check_id,a.screen_url,a.class_name, a.module_id, a.user_id from uam_user_screens as a inner join uam_screens as b on b.screen_id = a.screen_id where a.user_id = $user_id ORDER BY a.display_order ");

            $modules['user_role'] = $role[0]->role_name;
            $modules['userRoleID'] = $role[0]->role_id;
            // $modules['data'] = DB::select("select * from uam_modules where active_flag=0 and parent_module_id !=0 and module_type=1" );
            $modules['sub_module'] = DB::select("select * from uam_modules where active_flag=0 and module_type=2 ORDER BY display_order ASC");
            $modules['data'] = DB::select("select * from uam_modules where active_flag=0 and parent_module_id !=0 and module_type=1
            AND module_id IN (SELECT a.module_id FROM uam_user_screens AS a
            INNER JOIN uam_modules AS b ON b.module_id=a.module_id
            WHERE USER_id=$user_id) OR module_id IN (select DISTINCT a.parent_module_id 
            from uam_user_screens as a 
            inner join uam_modules as b on b.module_id = a.module_id
            where a.user_id =$user_id AND b.module_type=2) ORDER BY uam_modules.display_order ASC");

            $screens['unique'] = DB::select("SELECT DISTINCT a.module_id, c.parent_module_id from uam_module_screens as a 
            inner join uam_screens as b on b.screen_id = a.screen_id 
            inner join uam_modules as c on c.module_id = a.module_id 
            inner join uam_role_screens as d on d.module_screen_id=a.module_screen_id
            where b.active_flag=0 and d.role_id in ($role_id) order by b.display_order asc");

            $screens['unique1'] = DB::select("SELECT GROUP_CONCAT(DISTINCT c.parent_module_id SEPARATOR ' , ') as un from uam_module_screens as a 
            inner join uam_screens as b on b.screen_id = a.screen_id 
            inner join uam_modules as c on c.module_id = a.module_id 
            inner join uam_role_screens as d on d.module_screen_id=a.module_screen_id
            where b.active_flag=0 and d.role_id in ($role_id) AND module_type=2 order by c.display_order asc");

            $screens['unique2'] = DB::select("select GROUP_CONCAT(DISTINCT b.module_id SEPARATOR ' , ') AS un from uam_user_screens as a 
            inner join uam_modules as b on b.module_id = a.module_id
            where a.user_id =$user_id AND b.module_type=2 order by b.display_order asc");

            $modules['bg_images'] = DB::select("select * from image_upload");
            $modules['user_profile'] = DB::select("SELECT a.id , a.profile_image , a.name , b.role_name FROM users AS a INNER JOIN uam_roles AS b ON a.array_roles = b.role_id WHERE id = $user_id;");
            $modules['parentModule'] = DB::select("select DISTINCT b.class_name, a.module_id, b.module_name,a.user_id from uam_user_screens as a inner join uam_modules as b on b.module_id = a.module_id where a.user_id = $user_id");

            $screens['parentScreen'] = DB::select("select a.route_url,a.screen_id,a.screen_name,a.screen_url,a.class_name, a.module_id, a.user_id from uam_user_screens as a inner join uam_screens as b on b.screen_id = a.screen_id where a.user_id = $user_id ORDER BY a.display_order ");
            $editorKey = DB::select("SELECT token_key FROM isms_settings WHERE key_type='tinymce'");
            $modules['editorKey'] = $editorKey[0]->token_key;
            $response = [
                'modules' => $modules,
                'screens' => $screens,

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

public function fillscreensbasedonuser($id)
{
    try{ 
         $method = 'Method => UamDataController => fillscreensbasedonuser';
        $id = $this->decryptData($id); 
         
        
        $screen_permission = DB::select("select  GROUP_CONCAT( b.permission ) as 'permissions' from uam_user_screens as a inner join uam_user_screen_permissions as b on b.user_screen_id =  a.user_screen_id where  a.route_url = '$id' and a.user_id =".auth()->user()->id);


        $response = [
            'screen_permission' => $screen_permission,
            
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

    }catch(\Exception $exc){
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

public function filldynamiclist($id)
{       
    try{
        $method = 'Method => UamDataController => filldynamiclist';
        $id = $this->decryptData($id); 
   
   

        $getrole=DB::select("select array_roles from users where id=".auth()->user()->id);
      
        $getuserrole=$getrole[0]->array_roles;
       

        $getscreen=DB::select("select screen_id from uam_screens where route_url LIKE '%$id%'");
         
        $getscreenid=$getscreen[0]->screen_id;
      

        $dynamic_list = DB::select("select a.listfieldname,a.listfieldname_field_name from dynamiclist_field as a inner join dynamiclistallocation_field as b on b.dynamiclist_field_id= a.dynamiclist_field_id where b.active_flag='0' and  b.screen_id = '$getscreenid' and b.role_id =".$getuserrole); 

        // $response = [
            
        //      'dynamic_list' => $dynamic_list
        // ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $dynamic_list;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

    }catch(\Exception $exc){
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



public function fillscreensbasedondash($id)
{
    try{
        $id = $this->decryptData($id);
        $method = 'Method => UamDataController => fillscreensbasedondash';

        $screen_permission = DB::select("select count(b.dashboard_list_name) as count  from user_selected_dashboard_list a 
            inner join user_dashboard_list as b on b.dashboard_list_id = a.user_dashboard_list_id
            where  b.route_url = '$id' and a.user_id = ".auth()->user()->id);  


        $response = [
            'screen_permission' => $screen_permission,
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

    }catch(\Exception $exc){
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


public function fillscreensbasedondocument($id)
{
    try{
        $method = 'Method => UamDataController => fillscreensbasedondocument';
        $id = $this->decryptData($id);


        $screen_permission = DB::select("select  GROUP_CONCAT( b.permission ) as 'permissions' from uam_user_screens as a inner join uam_user_screen_permissions as b on b.user_screen_id =  a.user_screen_id where
              a.route_url LIKE '%$id%' and a.user_id = ".auth()->user()->id);  


        $response = [
            'screen_permission' => $screen_permission,
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

    }catch(\Exception $exc){
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


// public function parent_module_data()
// {

//     try {
//         $method = 'Method => UamDataController => parent_module_data';
//         $rows = DB::table('uam_modules')
//         ->select('*')
//         ->where('parent_module_id',0)
//         ->get();
//         return $this->sendDataResponse($rows);
//     } catch(\Exception $exc){
//         
//     }
// }

// public function module_data()
// {
//     try {
//         $method = 'Method => UamDataController => module_data';
//               $rows = DB::table('uam_modules')
//         ->select('*')
//         ->where('parent_module_id', '!=' , 0)
//         ->get();
//         return $this->sendDataResponse($rows);

//     } catch(\Exception $exc){
//         
//     }
// }


// public function screens_data()
// {
//     try {
//         $method = 'Method => UamDataController => screens_data';
//              $rows =  DB::select("select b.screen_id,b.screen_name,c.module_id
//          from uam_module_screens as a inner join uam_screens as b on b.screen_id = a.screen_id inner join uam_modules as c on c.module_id = a.module_id "); 

//         return $this->sendDataResponse($rows);

//     } catch(\Exception $exc){
//         
//     }
// }


// public function permissions_data()
// {
//     try {
//         $method = 'Method => UamDataController => permissions_data';

//         $rows = DB::table('uam_screen_permissions')
//         ->select('*')
//         ->get();
//         return $this->sendDataResponse($rows);

//     } catch(\Exception $exc){
//         
//     }
// }





// public function screen_data()
// {
//        // echo "naa";exit;
//     try {
//         $method = 'Method => UamDataController => screen_data';

//          $user_id =  auth()->user()->id;

//         $rows = DB::select("select a.screen_id,a.screen_name,a.screen_url,a.class_name, a.module_id, a.user_id from uam_user_screens as a inner join uam_screens as b on b.screen_id = a.screen_id where a.user_id = $user_id ORDER BY a.display_order ");

//         //return $rows;

//         return $this->sendDataResponse($rows);


//     } catch(\Exception $exc){
//         
//     }

// }


//   public function work_flow_id_get($id)
//     {
//         try{
//             $id = $this->decryptData($id);

//             $rows = DB::select("select * from uam_screens where route_url ='$id'") ;            

//             return $this->sendDataResponse($rows);
//         }catch(\Exception $exc){
//             return $this->sendLog('Method => ScreenDetailsController => work_flow_id_get', $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//         }
//     }


}
