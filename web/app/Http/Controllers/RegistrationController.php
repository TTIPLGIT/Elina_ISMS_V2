<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class RegistrationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        // $request =  array();
        // $request['user_id'] = $user_id;

        // $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        // $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        // $response = json_decode($response);
        // $objData = json_decode($this->decryptData($response->Data)); 

        // $rows = json_decode(json_encode($objData->Data), true); 
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('Registration.index', compact('user_id','menus','screens','modules'));
        
        //
    }
    // public function Registration()
    // {
    //     //
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $user_id=$request->session()->get("userID");
        $method = 'Method => LoginController => Register_screen';

        $urd = $request->urd;
        if($urd == "exp"){
            $gatewayURL = config('setting.api_gateway_url').'/Register/expcreate';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $user_id = json_decode(json_encode($objData->Data), true);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.workexpcreate', compact('user_id','menus','screens','modules'));
        }
       
        //
    }

    public function educreate(Request $request)
    {
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $user_id=$request->session()->get("userID");
        $method = 'Method => LoginController => Register_screen';

     
            $gatewayURL = config('setting.api_gateway_url').'/Register/educreate';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $user_id = json_decode(json_encode($objData->Data), true);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.educationcreate', compact('user_id','menus','screens','modules'));
    
       
        //
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
         
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;
            if($user_details=="general"){
              
              $data = array();   
                $data['fname'] = $request->fname;
                $data['lname'] = $request->lname;
                $data['gender'] = $request->gender;
                $data['Address_line1'] = $request->Address_line1;
                $data['district'] = $request->district;
                $data['constituency'] = $request->constituency;
                $data['village'] = $request->village;
                $data['lvc'] = $request->lvc;
                $data['role_c'] = $request->role_c;
                $data['user_id'] = $user_id;
               
                $data['nin'] = $request->nin;
                $data['passport'] = $request->passport;

                $storagepath_ninf = public_path() . '/userdocuments/registration/general/nin/'. $user_id ;
                $storagepath_ninf1 = '/userdocuments/registration/general/nin/'. $user_id ;
                if (!File::exists($storagepath_ninf)) {
                    File::makeDirectory($storagepath_ninf);
                }
                $data['ninfp'] = $storagepath_ninf1;
                $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/'. $user_id ;
                $storagepath_ppf1 = '/userdocuments/registration/general/pp/'. $user_id ;
                if (!File::exists($storagepath_ppf)) {
                    File::makeDirectory($storagepath_ppf);
                }
                $data['ppfp'] = $storagepath_ppf1;
                $documentsf =  $request['ninf'];
               
                $files = $documentsf->getClientOriginalName();
               
                $findspace = array(' ', '&',"'",'"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files);
                $documentsf->move($storagepath_ninf, $proposal_files);
                $data['ninfn'] = $proposal_files;  
                
                
                
                $documentsf =  $request['ppf'];
               
                $files = $documentsf->getClientOriginalName();
               
                $findspace = array(' ', '&',"'",'"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files);
                $documentsf->move($storagepath_ppf, $proposal_files);
                $data['ppfn'] = $proposal_files;          
              
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;
    
                $gatewayURL = config('setting.api_gateway_url').'/user_general/storedata';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
        
                if ($objData->Code == 200) {
                    return redirect(route('Registration.index'))->with('success', 'General Details Created Successfully');
                }
        
                if ($objData->Code == 400) {
                    return redirect(route('Registration.index'))->with('fail', 'General Details Already Exists');
                    }
                }
        
        
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
            else if($user_details=="educate"){
                
                $countug = $request->attachment_countug;
                $countpg = $request->attachment_countpg;
                $countdip = $request->attachment_countdip;
                $countphd = $request->attachment_countphd;
                $randomId       =   rand(2,50);
                $data = array(); 
                if($countug === "0") {
                    $data['ug'] ="" ;
                }
                if($countpg === "0") {
                    $data['pg'] ="" ;
                }
                if($countdip === "0") {
                    $data['dip'] ="" ;
                } 
                for($i=0; $i < $countug; $i++){
                $data['ug'][$i] = $request['ug'][$i]; 
                $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/'. $user_id ;
                $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/'. $user_id ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/'. $user_id.'/' . $i ;
                $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/'. $user_id ;
                $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/'. $user_id ;

                if (!File::exists($storagepath_reuggc)) {
                    File::makeDirectory($storagepath_reuggc);
                }
                $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/'. $user_id .'/' . $i ;
                $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/'. $user_id .'/' . $i ;

                if (!File::exists($storagepath_reuggc)) {
                    File::makeDirectory($storagepath_reuggc);
                }
                $data['ug'][$i]['cfp'] = $storagepath_reugcc1;
                    $documentsf =  $request['ug'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reugcc, $proposal_files);
                    $data['ug'][$i]['cfn'] = $proposal_files;  
                    
                    
                    $data['ug'][$i]['gfp'] = $storagepath_reuggc1;
                    $documentsf =  $request['ug'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reuggc, $proposal_files);
                    $data['ug'][$i]['gfn'] = $proposal_files;          
                    $data['ug'][$i]['table'] = 'user_education_ug_details';
                    $data['ug'][$i]['user_id'] = $user_id;
                }
                for($i=0; $i < $countpg; $i++){
                $data['pg'][$i] = $request['pg'][$i];  
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/'. $user_id ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/'. $user_id ;
    
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/'. $user_id .'/' . $i ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/'. $user_id .'/' . $i;
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/'. $user_id ;
                $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/'. $user_id ;
            
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/'. $user_id .'/' . $i;
                $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
            

                $data['pg'][$i]['cfp'] = $storagepath_repgcc1;
                    $documentsf =  $request['pg'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repgcc, $proposal_files);
                    $data['pg'][$i]['cfn'] = $proposal_files;  
                    
                    
                    $data['pg'][$i]['gfp'] = $storagepath_repggc1;
                    $documentsf =  $request['pg'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repggc, $proposal_files);
                    $data['pg'][$i]['gfn'] = $proposal_files; 
                    $data['pg'][$i]['table'] = 'user_education_pg_details';
                    $data['pg'][$i]['user_id'] = $user_id;
                }
                for($i=0; $i < $countdip; $i++){
                $data['dip'][$i] = $request['dip'][$i];
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/'. $user_id ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/'. $user_id ;

                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }

                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/'. $user_id .'/' . $i ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/'. $user_id ;
                $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/'. $user_id ;
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/'. $user_id .'/' . $i ;
                $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/'. $user_id .'/' . $i ;
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $data['dip'][$i]['cfp'] = $storagepath_repgcc1;
                    $documentsf =  $request['dip'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repgcc, $proposal_files);
                    $data['dip'][$i]['cfn'] = $proposal_files;  
                    
                    
                    $data['dip'][$i]['gfp'] = $storagepath_repggc1;
                    $documentsf =  $request['dip'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repggc, $proposal_files);
                    $data['dip'][$i]['gfn'] = $proposal_files;        
                    $data['dip'][$i]['table'] = 'user_education_dip_details';
                    $data['dip'][$i]['user_id'] = $user_id;
                }
            
                $data['user_id'] = $user_id;
                for($i=0; $i < $countphd; $i++){
                $data['phd'][$i] = $request['phd'][$i];       
                }
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/storedynamicdata';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Education Details Stored Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
            else if($user_details=="exp"){
                $countc = $request->attachment_countc;
                $counte = $request->attachment_counte;

                $randomId       =   rand(2,50);
                $data = array();   
                for($i=0; $i < $countc; $i++){
                $data['cert'][$i] = $request['cert'][$i]; 
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/'. $user_id ;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/'. $user_id ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/'. $user_id.'/' . $i ;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
               
                $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                    $documentsf =  $request['cert'][$i]['certd'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reugcc, $proposal_files);
                    $data['cert'][$i]['certfn'] = $proposal_files;    
                    $data['cert'][$i]['table'] = 'user_exp_cert_details';
                    $data['cert'][$i]['user_id'] = $user_id;
                }
                for($i=0; $i < $counte; $i++){
                $data['wre'][$i] = $request['wre'][$i];  
               
                    $data['wre'][$i]['table'] = 'user_exp_wre_details';
                    $data['wre'][$i]['user_id'] = $user_id;
                }
                $data['wrq'] = $request['wrq'];
                $data['wrq']['table'] = "user_exp_wrq_details";
                $data['wrq']['user_id'] = $user_id;
                $data['exp']['we'] = $request['we'];
                $data['exp']['wrqch'] = $request['wrqch'];
                $data['exp']['certc'] = $countc;
                $data['exp']['expc'] = $counte;
                $data['user_id'] = $user_id;
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/storedynamicdata1';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
     
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Education Details Stored Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
            else if($user_details=="eligibleq"){
                $countq = count($request->q);

                $data = array();   
                for($i=0; $i < $countq; $i++){
                $data['q'][$i] = $request['q'][$i+1]; 
                 $data['q'][$i]['table'] = 'user_eligible_qa_details';
                    $data['q'][$i]['user_id'] = $user_id;
                }
              
                $data['user_id'] = $user_id;
               

                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/storeeqans';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Eligible Details Stored Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Eligibile Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        //
    }
    public function view_proposal_documents(Request $request)
    {
        Log::error("as");
        $path = $request->id;
        Log::error($path);
        $storagepath = public_path() . $path;
        Log::error($storagepath);
        $converter = new OfficeConverterController($storagepath);
        Log::error($converter);
        $converter->convertTo('document-view.pdf');
      
        $documentViewPath = '/documents/pdfview' . '/document-view.pdf';
        Log::error($documentViewPath);
        return $documentViewPath;
    }

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.generalshow', compact('user_id','rows','menus','screens','modules'));

    }

    public function edushow(Request $request, $id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $education = $rows['education'];
        $educationstate = $rows['educationstate'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.educationshow', compact('user_id','rows','education','educationstate','menus','screens','modules'));
    }
    public function expshow(Request $request, $id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $Experience = $rows['Experience'];
        $check = $rows['check'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.workexpshow', compact('user_id','rows','Experience','check','menus','screens','modules'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request, $id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.generaledit', compact('user_id','rows','menus','screens','modules'));
    }

    public function eduedit(Request $request, $id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $education = $rows['education'];
        $educationstate = $rows['educationstate'];
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.educationedit', compact('user_id','rows','education','educationstate','menus','screens','modules'));
    }

    public function expedit(Request $request, $id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url').'/Register/screenapl';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
     
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);
        $Experience = $rows['Experience'];
        $check = $rows['check'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('Registration.workexpedit', compact('user_id','rows','Experience','check','menus','screens','modules'));
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
        try {
         
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;
             if($user_details=="eligibleq"){
                $countq = count($request->q);

                $data = array();   
                for($i=0; $i < $countq; $i++){
                $data['q'][$i] = $request['q'][$i+1]; 
                 $data['q'][$i]['table'] = 'user_eligible_qa_details';
                    $data['q'][$i]['user_id'] = $user_id;
                }
              
                $data['user_id'] = $user_id;
               
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/updateeqans';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Eligible Details Updated Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Eligibile Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
            elseif($user_details=="general"){
                
                $data = array();   
                  $data['fname'] = $request->fname;
                  $data['lname'] = $request->lname;
                  $data['gender'] = $request->gender;
                  $data['Address_line1'] = $request->Address_line1;
                  $data['district'] = $request->district;
                  $data['constituency'] = $request->constituency;
                  $data['village'] = $request->village;
                  $data['lvc'] = $request->lvc;
                  $data['role_c'] = $request->role_c;
                  $data['user_id'] = $user_id;
                 
                  $data['nin'] = $request->nin;
                  $data['passport'] = $request->passport;
  
                  $storagepath_ninf = public_path() . '/userdocuments/registration/general/nin/'. $user_id ;
                  $storagepath_ninf1 = '/userdocuments/registration/general/nin/'. $user_id ;
                  if (!File::exists($storagepath_ninf)) {
                      File::makeDirectory($storagepath_ninf);
                  }
                  $data['ninfp'] = $storagepath_ninf1;
                  $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/'. $user_id ;
                  $storagepath_ppf1 = '/userdocuments/registration/general/pp/'. $user_id ;
                  if (!File::exists($storagepath_ppf)) {
                      File::makeDirectory($storagepath_ppf);
                  }
                  $data['ppfp'] = $storagepath_ppf1;
                  $f1 = $request['f1'];
                  $f2 = $request['f2'];
                  if($f1 == '0'){
                    if (!File::exists($storagepath_ppf)) {
                        File::cleanDirectory($storagepath_ppf);
                    }
                    $storagepath_ppf = public_path() . '/userdocuments/registration/general/nin/'. $user_id ;

                    if (!File::exists($storagepath_ppf)) {
                        File::makeDirectory($storagepath_ppf);
                    }
                   
                  $documentsf =  $request['ninf'];
                 
                  $files = $documentsf->getClientOriginalName();
                 
                  $findspace = array(' ', '&');
                  $replacewith = array('-', '-');
                  $proposal_files = str_replace($findspace, $replacewith, $files);
                  $documentsf->move($storagepath_ninf, $proposal_files);
                  $data['ninfn'] = $proposal_files;  
                  
                  
                }
                else{
                    $data['ninfn'] = $request['oldninfn']; 
                }
                if($f2 == '0'){

                    if (File::exists($storagepath_ppf)) {
                        File::cleanDirectory($storagepath_ppf);
                    }
                    $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/'. $user_id ;

                    if (!File::exists($storagepath_ppf)) {
                        File::makeDirectory($storagepath_ppf);
                    }
                  $documentsf =  $request['ppf'];
                
                  $files = $documentsf->getClientOriginalName();
                 
                  $findspace = array(' ', '&');
                  $replacewith = array('-', '-');
                  $proposal_files = str_replace($findspace, $replacewith, $files);
                  $documentsf->move($storagepath_ppf, $proposal_files);
                  $data['ppfn'] = $proposal_files;          
                }
                else{
                    $data['ppfn'] = $request['oldppfn']; 
                }
               

                  $encryptArray = $data;
                  $request = array();
                  $request['requestData'] = $encryptArray;
      
                  $gatewayURL = config('setting.api_gateway_url').'/user_general/updatedata';
              
                  $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
          
                  $response1 = json_decode($response);
                  if($response1->Status == 200 && $response1->Success){
                  $objData = json_decode($this->decryptData($response1->Data));
          
                  if ($objData->Code == 200) {
                      return redirect(route('Registration.index'))->with('success', 'General Details updated Successfully');
                  }
          
                  if ($objData->Code == 400) {
                      return redirect(route('Registration.index'))->with('fail', 'General Details Already Exists');
                      }
                  }
          
          
                  else {
                  $objData = json_decode($this->decryptData($response1->Data));
                  echo json_encode($objData->Code);exit;                            
                  }
            }
            else if($user_details=="educate"){
                $countug = $request->attachment_countug;
                $countpg = $request->attachment_countpg;
                $countdip = $request->attachment_countdip;
                $countphd = $request->attachment_countphd;
                $randomId       =   rand(2,50);
                $data = array();   
                if($countug === "0") {
                    $data['ug'] ="" ;
                }
                if($countpg === "0") {
                    $data['pg'] ="" ;
                }
                if($countdip === "0") {
                    $data['dip'] ="" ;
                } 
                for($i=0; $i < $countug; $i++){
                $data['ug'][$i] = $request['ug'][$i]; 
                $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/'. $user_id ;
                $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/'. $user_id ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/'. $user_id.'/' . $i ;
                $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/'. $user_id ;
                $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/'. $user_id ;

                if (!File::exists($storagepath_reuggc)) {
                    File::makeDirectory($storagepath_reuggc);
                }
                $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/'. $user_id .'/' . $i ;
                $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/'. $user_id .'/' . $i ;

                if (!File::exists($storagepath_reuggc)) {
                    File::makeDirectory($storagepath_reuggc);
                }
                $ugcyn1 = $i+1;
                $ugcyn = $request["ugcyn".$ugcyn1];

                if($ugcyn == "0"){
                
                $data['ug'][$i]['cfp'] = $storagepath_reugcc1;
                    $documentsf =  $request['ug'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reugcc, $proposal_files);
                    $data['ug'][$i]['cfn'] = $proposal_files;  
                }
                else{
                    $data['ug'][$i]['cfp'] = $request['ug'][$i]['ocfp'];
                    $data['ug'][$i]['cfn'] = $request['ug'][$i]['ocfn'];  
                }
                $uggyn1 = $i+1;
                $uggyn = $request["uggyn".$uggyn1];
                    if($uggyn=="0"){
                    $data['ug'][$i]['gfp'] = $storagepath_reuggc1;
                    $documentsf =  $request['ug'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reuggc, $proposal_files);
                
                    $data['ug'][$i]['gfn'] = $proposal_files;   
                    }    
                    else{
                        $data['ug'][$i]['gfp'] = $request['ug'][$i]['ogfp'];
                        $data['ug'][$i]['gfn'] = $request['ug'][$i]['ogfn'];  
                    }   
                    $data['ug'][$i]['table'] = 'user_education_ug_details';
                    $data['ug'][$i]['user_id'] = $user_id;
                }
                
                for($i=0; $i < $countpg; $i++){
                $data['pg'][$i] = $request['pg'][$i];  
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/'. $user_id ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/'. $user_id ;
    
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/'. $user_id .'/' . $i ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/'. $user_id .'/' . $i;
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/'. $user_id ;
                $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/'. $user_id ;
            
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/'. $user_id .'/' . $i;
                $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $pgcyn1 = $i+1;
                $pgcyn = $request["pgcyn".$pgcyn1];
                if($pgcyn=="0"){
                $data['pg'][$i]['cfp'] = $storagepath_repgcc1;
                    $documentsf =  $request['pg'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repgcc, $proposal_files);
                    $data['pg'][$i]['cfn'] = $proposal_files;  
                }
                else{
                    $data['pg'][$i]['cfp'] = $request['pg'][$i]['ocfp'];
                    $data['pg'][$i]['cfn'] = $request['pg'][$i]['ocfn'];  
                }
                $pggyn1 = $i+1;
                $pggyn = $request["pggyn".$pggyn1];
                    if($pggyn=="0"){
                    $data['pg'][$i]['gfp'] = $storagepath_repggc1;
                    $documentsf =  $request['pg'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repggc, $proposal_files);
                    $data['pg'][$i]['gfn'] = $proposal_files; 
                    }
                    else{
                        $data['pg'][$i]['gfp'] = $request['pg'][$i]['ogfp'];
                        $data['pg'][$i]['gfn'] = $request['pg'][$i]['ogfn'];  
                    } 
                    $data['pg'][$i]['table'] = 'user_education_pg_details';
                    $data['pg'][$i]['user_id'] = $user_id;
                }
                for($i=0; $i < $countdip; $i++){
                $data['dip'][$i] = $request['dip'][$i];
                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/'. $user_id ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/'. $user_id ;

                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }

                $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/'. $user_id .'/' . $i ;
                $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_repgcc)) {
                    File::makeDirectory($storagepath_repgcc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/'. $user_id ;
                $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/'. $user_id ;
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/'. $user_id .'/' . $i ;
                $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/'. $user_id .'/' . $i ;
            
                if (!File::exists($storagepath_repggc)) {
                    File::makeDirectory($storagepath_repggc);
                }
                $dipcyn1 = $i+1;
                $dipcyn = $request["dipcyn".$dipcyn1];
                if($dipcyn=="0"){
                $data['dip'][$i]['cfp'] = $storagepath_repgcc1;
                    $documentsf =  $request['dip'][$i]['consolidate_mark'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repgcc, $proposal_files);
                    $data['dip'][$i]['cfn'] = $proposal_files;  
                }
                else{
                    $data['dip'][$i]['cfp'] = $request['dip'][$i]['ocfp'];
                    $data['dip'][$i]['cfn'] = $request['dip'][$i]['ocfn'];  
                }
                $dipgyn1 = $i+1;
                $dipgyn = $request["dipgyn".$dipgyn1];
                if($dipgyn=="0"){
                    $data['dip'][$i]['gfp'] = $storagepath_repggc1;
                    $documentsf =  $request['dip'][$i]['garduation_certificate'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_repggc, $proposal_files);
                    $data['dip'][$i]['gfn'] = $proposal_files;      
                }  else{
                    $data['dip'][$i]['gfp'] = $request['dip'][$i]['ogfp'];
                    $data['dip'][$i]['gfn'] = $request['dip'][$i]['ogfn'];  
                } 
                
                    $data['dip'][$i]['table'] = 'user_education_dip_details';
                    $data['dip'][$i]['user_id'] = $user_id;
                }

                $data['delete']['table'] = 'user_education_dip_details';
                $data['user_id'] = $user_id;
                for($i=0; $i < $countphd; $i++){
                $data['phd'][$i] = $request['phd'][$i];       
                }
                $encryptArray = $data;

                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/updatedynamicdata';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Education Details Updated Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
            else if($user_details=="exp"){
                $countc = $request->attachment_countc;
                $counte = $request->attachment_counte;
                $randomId       =   rand(2,50);
                $data = array();   
                for($i=0; $i < $countc; $i++){
                $data['cert'][$i] = $request['cert'][$i]; 
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/'. $user_id ;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/'. $user_id ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/'. $user_id.'/' . $i ;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/'. $user_id .'/' . $i ;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $q = $i+1;
                $f = $request["f".$q];
                if($f=="0"){
                $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                    $documentsf =  $request['cert'][$i]['certd'];
                
                    $files = $documentsf->getClientOriginalName();
                
                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reugcc, $proposal_files);
                    $data['cert'][$i]['certfn'] = $proposal_files;  
                }
                else{
                    $data['cert'][$i]['certfp'] = $request['cert'][$i]['ocfp'];
                    $data['cert'][$i]['certfn'] = $request['cert'][$i]['ocfn'];  
                }
                    
                   
                    $data['cert'][$i]['table'] = 'user_exp_cert_details';
                    $data['cert'][$i]['user_id'] = $user_id;
                }
                for($i=0; $i < $counte; $i++){
                $data['wre'][$i] = $request['wre'][$i];  
               
                    $data['wre'][$i]['table'] = 'user_exp_wre_details';
                    $data['wre'][$i]['user_id'] = $user_id;
                }
                $data['wrq'] = $request['wrq'];
                $data['wrq']['table'] = "user_exp_wrq_details";
                $data['wrq']['user_id'] = $user_id;
                $data['exp']['we'] = $request['we'];
                $data['exp']['wrqch'] = $request['wrqch'];
                $data['exp']['certc'] = $countc;
                $data['exp']['expc'] = $counte;
                $data['user_id'] = $user_id;
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/updatedynamicdata1';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Experience Details Updated Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
         
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;

              
                $data['user_id'] = $user_id;
                $data['q'][0]['table'] = 'user_eligible_qa_details';
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/deleteeqans';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Eligible Details Deleted Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Eligibile Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
           
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        
        
        //
    }
    public function destroygen(Request $request, $id)
    {
        try {
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;

              
                $data['user_id'] = $user_id;
                $data['q'][0]['table'] = 'user_general_details';
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/deletegen';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'General Details Deleted Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'General Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
           
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        
        
        //
    }
    public function destroyexp(Request $request)
    {
        try {
         
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;

              
                $data['user_id'] = $user_id;
                $data['cert'][0]['table'] = 'user_exp_cert_details';
                $data['wrq'][0]['table'] = 'user_exp_cert_details';
                $data['wre'][0]['table'] = 'user_exp_cert_details';
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/deleteexp';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Experience Details Deleted Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Experience Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
           
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        
        
        //
    }
    public function destroyedu(Request $request)
    {
        try {
         
            $user_id=$request->session()->get("userID");
            if($user_id==null){
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details=$request->user_details;

              
                $data['user_id'] = $user_id;
                $data['ug'][0]['table'] = 'user_education_ug_details';
                $data['pg'][0]['table'] = 'user_education_pg_details';
                $data['dip'][0]['table'] = 'user_education_dip_details';
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url').'/user_general/deleteedu';
            
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
               
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('Registration.index'))->with('success', 'Education Details Deleted Successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Education Details Already Exists');
                        }
                }
    
    
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
           
         } catch(\Exception $exc){ 
                       
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
         }
        
        
        //
    }
}
