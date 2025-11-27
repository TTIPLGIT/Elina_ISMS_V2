<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class ParentvideouploadController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => ParentvideouploadController => index';
        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/videocreation/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $pendingActivities = $rows['pendingActivities'];
        $rows = $rows['rows'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('video_upload_creation.index', compact('user_id', 'modules', 'screens', 'rows', 'pendingActivities'));
    }

    public function create(Request $request)
    {
        try {
            $method = 'Method => ParentvideouploadController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/createdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    //  $email = $parant_data['email'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('video_upload_creation.create', compact('rows', 'screens', 'modules'));
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


    public function store(Request $request)
    {

        try {
            $method = 'Method => ParentvideouploadController => store';
            // $file_array = array();
            // $pathName = $request->activity_name;

            // if ($request->hasFile('file')) {
            //     foreach ($request->file('file') as $key => $imageFile) {
            //         $storagePath = public_path() . '/activity_document/' . $pathName;
            //         $path = $pathName;
            //         $imageName = $imageFile->getClientOriginalName();
            //         $imageFile->move($storagePath, $imageName, $path);
            //         $file_array[$key] = $imageName;
            //     }
            // }

            $data = array();
            $data['group'] = $request->age;
            $data['type'] = $request->Category;
            $data['activity_name'] = $request->activity_name;
            $data['description'] = $request->description;
            // $data['attached_file_path'] = $storagePath;
            // $data['filepath'] = $pathName;
            // $data['imagename'] = $file_array;
            $data['instruction'] = $request->instruction;

            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('video_creation.index'))
                        ->with('success', 'Activity Created Successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect(route('video_creation.index'))
                        ->with('fail', 'Activity Name Already Exists');
                }
                if ($objData->Code == 401) {
                    return redirect(route('/'))->with('error', 'User Session Expired');
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

    public function show($id)
    {

        try {

            $method = 'Method => ParentvideouploadController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);


                    $rows = $parant_data['rows'];


                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('parent_video_upload.show', compact('rows', 'screens', 'modules'));
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
            $method = 'Method => ParentvideouploadController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $video = $parant_data['video'];

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('video_upload_creation.edit', compact('rows', 'screens', 'modules', 'video'));
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
    public function show_1($id)
    {

        try {

            $method = 'Method => ParentvideouploadController => show_1';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/master/videocreation/data_edit_1/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);


                    $rows = $parant_data['rows'];
                    $activity = $parant_data['activity'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('video_upload_creation.show', compact('rows', 'screens', 'modules', 'activity'));
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

    public function edit_1($id)
    {
        try {
            $method = 'Method => ParentvideouploadController => edit_1';
            $gatewayURL = config('setting.api_gateway_url') . '/master/videocreation/data_edit_1/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $video = $parant_data['video']; //dd($rows , $video);
                    $activity_materials = $parant_data['activity_materials']; //dd($activity_materials);

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('video_upload_creation.edit', compact('activity_materials', 'rows', 'screens', 'modules', 'video'));
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

    public function activity_materials($id)
    {
        try {
            $method = 'Method => ParentvideouploadController => edit_1';
            $gatewayURL = config('setting.api_gateway_url') . '/master/videocreation/data_edit_1/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $video = $parant_data['video'];
                    $activity_materials = $parant_data['activity_materials'];
                    $activity_materials_mapping = $parant_data['activity_materials_mapping'];

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('video_upload_creation.activity_materials', compact('activity_materials_mapping', 'activity_materials', 'rows', 'screens', 'modules', 'video'));
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


    public function parentindex(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => LoginController => parentindex';
        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/parentvideo/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $com = $rows['com'];
        $total = $rows['total'];
        $state = $rows['state'];
        $policy = $rows['policy'];
        $privacy_status = $rows['privacy_status'];
        $rows = $rows['rows'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('parent_video_upload.index', compact('privacy_status', 'policy', 'total', 'state', 'com', 'user_id', 'modules', 'screens', 'rows'));
    }

    public function parent_create($id)
    {

        try {
            $method = 'Method => ParentvideouploadController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/parentvideo/parent_createdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $rows =  $parant_data['rows'];
                    $comments = $parant_data['comments'];
                    $activitylist = $parant_data['activitylist'];
                    $video_link = $parant_data['video_link'];
                    $general_instruction = $parant_data['general_instruction'];
                    $currentID = $this->decryptData($id);
                    $activities_list = $parant_data['activities_list'];
                    $activitylist_nav = $parant_data['activitylist_nav'];
                    $activitylist_rejection = $parant_data['activitylist_rejection'];
                    $collection = new Collection($activities_list);

                    $currentIndex = $collection->search(function ($item) use ($currentID) {
                        return $item['activity_initiation_id'] === $currentID;
                    });

                    $previous = $collection->get($currentIndex - 1)['activity_initiation_id'] ?? null;
                    $next = $collection->get($currentIndex + 1)['activity_initiation_id'] ?? null;
                    $activityNav = [
                        'firstActivityID' => !empty($activities_list) ? $activities_list[0]['activity_initiation_id'] : null,
                        'lastActivityID' => !empty($activities_list) ? $activities_list[count($activities_list) - 1]['activity_initiation_id'] : null,
                        'previous' => $collection->get($currentIndex - 1)['activity_initiation_id'] ?? null,
                        'next' => $collection->get($currentIndex + 1)['activity_initiation_id'] ?? null,
                    ];
                    $vidAll = array();
                    foreach ($video_link as $key => $value) {
                        array_push($vidAll, $value['parent_video_upload_id']);
                    }
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('parent_video_upload.create', compact('activityNav', 'vidAll', 'previous', 'next', 'general_instruction', 'comments', 'activitylist', 'activitylist_nav', 'activitylist_rejection', 'rows', 'video_link', 'screens', 'modules'));
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

    public function description(Request $request)
    {
        $method = 'Method => ParentvideouploadController => description';
        try {

            $activity_id = $request->activity_id;
            $enrollment_id = $request->enrollment_id;
            // $this->WriteFileLog($activity_id);  


            $request = array();

            $request['requestData'] = $activity_id;
            $request['enrollment_id'] = $enrollment_id;

            $gatewayURL = config('setting.api_gateway_url') . '/parentvideo/description';

            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }



    public function parent_store(Request $request)
    {
        try {
            $method = 'Method => ParentvideouploadController => video_store';

            $data = array();


            $data['video_link'] = $request->video_link;
            $data['parent_video_upload_id'] = $request->parent_video_upload_id;
            $data['comments'] = $request->comments;
            $data['activity_description_id'] = $request->activity_description_id;
            $data['current_status'] = $request->current_status;
            $data['unable_flag'] = $request->unable;
            // dd($data);
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/parentstore';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $reid = $objData->Data;
                    return redirect(route('parent_video_upload.parent_create', $this->EncryptData($reid)))
                        ->with('success', 'Video uploaded successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Activity Name Already Exists');
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

    public function reupload_bulk(Request $request)
    {
        try {
            $method = 'Method => ParentvideouploadController => reupload_bulk';

            $data = array();


            $data['video_link'] = $request->video_link;
            $data['parent_video_upload_id'] = $request->parent_video_upload_id;
            $data['comments'] = $request->comments;
            $data['activity_description_id'] = $request->activity_description_id;
            $data['current_status'] = $request->current_status;
            $data['unable_flag'] = $request->unable;
            $data['sameVideoLink'] = $request->sameVideoLink;
            $rejectedReOpen = $request->rejectedReOpen; 
            $data['rejectedReOpen'] = $request->rejectedReOpen; 
            // dd('bulk', $data);
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/video/parent/reject/reupload/bulk';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $rejectedReOpenID = $objData->Data;
                    if($rejectedReOpenID == null){
                        return redirect(route('parent_video_upload.parentindex'))->with('success', 'Video uploaded successfully');
                    }
                    return redirect(route('parent_video_upload.parent_create', $this->EncryptData($rejectedReOpenID)))
                        ->with('success', 'Video uploaded successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Activity Name Already Exists');
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
    public function parent_store_bulk(Request $request)
    {
        try { //dd($request);
            $method = 'Method => ParentvideouploadController => video_store';
            $restorePage = $request->openID;
            $submit_type = $request->submit_type;
            $data = array();
            $data['video_link'] = $request->video_link;
            $data['parent_video_upload_id'] = $request->parent_video_upload_id;
            $data['comments'] = $request->comments;
            $data['activity_description_id'] = $request->activity_description_id;
            $data['current_status'] = $request->current_status;
            $data['activity_name'] = $request->activity_name;
            $data['submit_type'] = $request->submit_type;
            $data['save_flag'] = $request->save_flag;
            $data['restorePage'] = $restorePage;
            // dd($data);
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/parentstore/bulk';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $reid = $objData->Data;
                    if ($submit_type == 'Save') {
                        return redirect(route('parent_video_upload.parent_create', $this->EncryptData($reid)))->with('page', $restorePage)->with('info', 'Video Saved successfully');
                    } else {
                        return redirect(route('parent_video_upload.parent_create', $this->EncryptData($reid)))->with('success', 'Video uploaded successfully');
                    }
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Name Already Exists');
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
    public function update(Request $request, $id)
    {
        try {
            $method = 'Method =>  ParentvideouploadController => update_data';
            $data = array();
            $file_array = array();
            $pathName = $request->activity_name;
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $key => $imageFile) {
                    $storagePath = public_path() . '/activity_document/' . $pathName;
                    $path = $pathName;
                    $imageName = $imageFile->getClientOriginalName();
                    $imageFile->move($storagePath, $imageName, $path);
                    $file_array[$key] = $imageName;
                }
            }

            $description = $request->description;
            if (isset($description['new'])) {
                $newdescription = $description['new'];
                unset($description['new']);
            } else {
                $newdescription = '';
            }


            $instruction = $request->instruction;
            if (isset($instruction['new'])) {
                $newinstruction = $instruction['new'];
                unset($instruction['new']);
            } else {
                $newinstruction = '';
            }

            $data['id'] = $id;
            $data['activity_name'] = $request->activity_name;
            $data['description'] = $description;
            $data['attached_file_path'] = $pathName;
            $data['filepath'] = $pathName;
            $data['imagename'] = $file_array;
            $data['instruction'] = $instruction;
            $data['newdescription'] = $newdescription;
            $data['newinstruction'] = $newinstruction;
            // dd($data);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('video_creation.index'))->with('success', 'Activity Description Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Description Name Already Exists');
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

    public function delete($id)
    {

        try {
            $method = 'Method => ParentvideouploadController => delete';


            // $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/activity/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('video_creation.index'))->with('success', 'Activity Set Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('video_creation.index'))->with('fail', 'Something Went Wrong');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function policy_aggrement(Request $request)
    {
        try {
            $method = 'Method => ParentvideouploadController => policy_aggrement';

            $data = array();


            $data['enrollment_id'] = $request->enrollment_id;
            $data['activity_initiation_id'] = $request->activity_initiation_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/videocreation/policyaggrement';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $activity_initiation_id = $objData->Data;
                    return redirect(route('parent_video_upload.parent_create', $this->EncryptData($activity_initiation_id)))
                        ->with('success', 'You have Accepted our Privacy Policy');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Name Already Exists');
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

    public function activityAction(Request $request)
    {
        try {
            $method = 'Method => ParentvideouploadController => activityAction';

            // dd($request);
            $data = array();


            $data['activity_id'] = $request->activity_id;
            $data['action'] = $request->action;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/video/creation/action';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return Redirect::back()->with('success', 'Activity has been updated');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Name Already Exists');
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

    public function activity_materials_store(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method =>  ParentvideouploadController => update_data';
            $data = array();
            $data['id'] = $request->activity_id;
            $data['activity_name'] = $request->activity_name;
            $data['description'] = $request->description;
            $data['material'] = $request->material;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/activity/materials/mapping/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('video_creation.index'))->with('success', 'Activity Description Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Description Name Already Exists');
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
    public function materials_fetch(Request $request)
    {
        $method = 'Method => ParentvideouploadController => materials_fetch';
        try {
            $activity_id = $request->activity_id;
            $enrollment_id = $request->enrollment_id;
            $description_id = $request->description_id;

            $requestData = [
                'activity_id' => $activity_id,
                'enrollment_id' => $enrollment_id,
                'description_id' => $description_id
            ];

            $encryptArray = $this->encryptData($requestData);
            $requestData = [
                'requestData' => $encryptArray,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/parentvideo/materials';

            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestData), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }
    public function f2f_description(Request $request)
    {
        $method = 'Method => ParentvideouploadController => f2f_description';
        try {

            $activity_id = $request->activity_id;
            $enrollment_id = $request->enrollment_id;
            // Prepare data for encryption
            $requestData = [
                'activity_id' => $activity_id,
                'enrollment_id' => $enrollment_id,
            ];
            $encryptArray = $this->encryptData($requestData);
            $requestData = [
                'requestData' => $encryptArray,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/parentvideo/f2fdescription';

            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestData), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    // echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }
}
