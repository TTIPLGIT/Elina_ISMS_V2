<?php

namespace App\Http\Controllers;
use App\Rules\NoUrls;
use Validator;
use Illuminate\Http\Request;

class SchoolenrollmentController extends BaseController
{
    public function index(Request $request)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {

                $method = 'Method => LoginController => Register_screen';
                $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/index';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

                $response = json_decode($response);

                $objData = json_decode($this->decryptData($response->Data));

                $responce_data = json_decode(json_encode($objData->Data), true);
                $rows = $responce_data['rows'];
                
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                return view('enrollement.schoollist', compact('rows', 'menus', 'screens', 'modules'));
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function create(Request $request)
    {

        try {
            $method = 'Method => SchoolenrollmentController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/createdata';
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            // $response = json_decode($response);

            // if ($response->Status == 200 && $response->Success) {
            //     $objData = json_decode($this->decryptData($response->Data));

            //     if ($objData->Code == 200) {
            //         $parant_data = json_decode(json_encode($objData->Data), true);
            //         $rows = $parant_data['rows'];

            //         $menus = $this->FillMenu();
            //         $screens = $menus['screens'];
            //         $modules = $menus['modules'];
            return view('enrollement.schoolenroll');
            //     }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function store(Request $request)
    {
        try {
            $method = 'Method => SchoolenrollmentController => store';
            $validator = Validator::make($request->all(), [
                'input_field' => [new NoUrls],
                'g-recaptcha-response' => 'required|captcha',
            ]);
            
            if ($validator->fails()) {
                return back()->with('error', 'Recaptcha Failed');
            }

            $data = array();
            $data['school_name'] = $request->school_name;
            $data['school_principal_name'] = $request->school_principal_name;
            $data['status'] = $request->status;
            $data['school_building_name'] = $request->school_building_name;
            $data['school_builiding_address'] = $request->school_builiding_address;
            $data['school_district'] = $request->school_district;
            $data['building_contract'] = $request->building_contract;
            $data['admin_contract'] = $request->admin_contract;
            $data['phone_number'] = $request->phone_number;
            $data['telephone_number'] = $request->telephone_number;
            $data['school_email'] = $request->school_email;
            $data['year_of_establishment'] = $request->year_of_establishment;
            $data['totalstudent_population'] = $request->totalstudent_population;
            $data['totalteacher_population'] = $request->totalteacher_population;
            $data['infra_facility'] = $request->infra_facility;
            $data['school_curriculam'] = $request->school_curriculam;
            $data['school_policy'] = $request->school_policy;
            $data['school_type'] = $request->school_type;
            $data['school_teacher_ratio'] = $request->school_teacher_ratio;
            $data['have_exclusion_policy'] = $request->have_exclusion_policy;
            $data['multidisciplinary_team'] = $request->multidisciplinary_team;
            $data['multidisciplinary_team_desc'] = $request->multidisciplinary_team_desc;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('schoolenroll'))->with('success', 'Successsfully Submitted your form');
                    // return view('enrollement.schoolsubmit');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function show($id)
    {

        try {
            $method = 'Method => SchoolenrollmentController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];

                    $school_type = $rows[0]['school_type'];
                    $schooltype = json_decode($school_type, true);

                    $school_teacher_ratio = $rows[0]['school_teacher_ratio'];
                    $schoolteacherratio = json_decode($school_teacher_ratio, true);

                    $infra_facility = $rows[0]['infra_facility'];
                    $infrastructure = json_decode($infra_facility, true);

                    $school_curriculam = $rows[0]['school_curriculam'];
                    $curriculam = json_decode($school_curriculam, true);

                    $school_policy = $rows[0]['school_policy'];
                    $policy = json_decode($school_policy, true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('enrollement.schoolshow', compact('rows', 'screens', 'modules', 'schooltype', 'schoolteacherratio', 'infrastructure', 'curriculam', 'policy'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }


        //

    }

    public function edit($id)
    {
        try {
            $method = 'Method => SchoolenrollmentController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];

                    $schooltype = json_decode($rows[0]['school_type'], true);

                    $schoolteacherratio = json_decode($rows[0]['school_teacher_ratio'], true);

                    $infrastructure = json_decode($rows[0]['infra_facility'], true);

                    $curriculam = json_decode($rows[0]['school_curriculam'], true);

                    $policy = json_decode($rows[0]['school_policy'], true);


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('enrollement.schooledit', compact('rows', 'screens', 'modules', 'schooltype', 'schoolteacherratio', 'infrastructure', 'curriculam', 'policy'));
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

    public function update(Request $request, $id)
    {


        try {
            $method = 'Method =>  SchoolenrollmentController => update_data';
            $data = array();
            $data['id'] = $id;

            $data['school_name'] = $request->school_name;
            $data['school_principal_name'] = $request->school_principal_name;
            $data['status'] = $request->status;
            $data['school_building_name'] = $request->school_building_name;
            $data['school_builiding_address'] = $request->school_builiding_address;
            $data['school_district'] = $request->school_district;
            $data['building_contract'] = $request->building_contract;
            $data['admin_contract'] = $request->admin_contract;
            $data['phone_number'] = $request->phone_number;
            $data['telephone_number'] = $request->telephone_number;
            $data['year_of_establishment'] = $request->year_of_establishment;
            $data['totalstudent_population'] = $request->totalstudent_population;
            $data['totalteacher_population'] = $request->totalteacher_population;
            $data['infra_facility'] = $request->infra_facility;
            $data['school_curriculam'] = $request->school_curriculam;
            $data['school_policy'] = $request->school_policy;
            $data['school_type'] = $request->school_type;
            $data['school_teacher_ratio'] = $request->school_teacher_ratio;
            $data['have_exclusion_policy'] = $request->have_exclusion_policy;
            $data['multidisciplinary_team'] = $request->multidisciplinary_team;
            $data['multidisciplinary_team_desc'] = $request->multidisciplinary_team_desc;
            $data['school_email'] = $request->school_email;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/schoolenrollment/updatedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('enrollement.schoollist'))
                        ->with('success', 'enrollment Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'enrollment Name Already Exists');
                }
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
