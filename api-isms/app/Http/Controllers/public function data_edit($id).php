    public function data_edit($id)
    {
        try {

            $method = 'Method => activityInitiationController => data_edit';
            $id = $this->DecryptData($id);
            $authID = auth()->user()->id;
            $rows = DB::table('activity_initiation as ques')
                ->join('enrollment_details as qud', 'ques.enrollment_id', '=', 'qud.enrollment_id')
                ->join('activity as question', 'question.activity_id', '=', 'ques.activity_id')
                ->join('users as us', 'us.id', '=', 'ques.user_id')
                ->where('ques.activity_initiation_id', $id)
                ->select(
                    'ques.enrollment_id',
                    'ques.activity_initiation_id',
                    'qud.user_id as userID',
                    'qud.enrollment_child_num',
                    'qud.child_id',
                    'qud.child_name',
                    'question.activity_name',
                    'ques.status',
                    'ques.last_modified_date'
                )
                ->get();

            $enNum = $rows[0]->enrollment_id ?? null;

            $activity = DB::table('activity_initiation as a')
                ->join('activity as aa', 'aa.activity_id', '=', 'a.activity_id')
                ->where('a.enrollment_id', $enNum)
                ->where(function ($query) {
                    $query->where('action_flag', '!=', 1)
                        ->orWhereNull('action_flag');
                })
                ->select('aa.activity_id', 'aa.activity_name', 'a.activity_initiation_id')
                ->get();
            $activityshow = DB::table('activity_initiation as ques')
                ->join('activity_description as qud', 'ques.activity_id', '=', 'qud.activity_id')
                ->where('ques.activity_initiation_id', $id)
                ->select('ques.*', 'qud.*') // or specify only needed fields
                ->get();
            $userID = $rows[0]->userID ?? null;

            $lastactivity = DB::table('activity_initiation as a')
                ->join('activity as ac', 'ac.activity_id', '=', 'a.activity_id')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->join('parent_video_upload as c', 'c.activity_initiation_id', '=', 'a.activity_initiation_id')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'c.activity_description_id')
                ->leftJoin('face_to_face_observation as ff', 'ff.parent_video_id', '=', 'c.parent_video_upload_id')
                ->where('b.user_id', $userID)
                ->select(
                    'a.activity_id',
                    'c.f2f_flag',
                    'ff.*',
                    'c.enableflag',
                    'c.comments',
                    'a.activity_initiation_id',
                    'ac.activity_name',
                    'ad.description',
                    'a.last_modified_date',
                    'c.status',
                    'c.parent_video_upload_id',
                    'ad.activity_description_id',
                    'c.coordinator_observation',
                    'c.head_observation',
                    'c.physical_observation_name',
                    'c.physical_observation_result',
                    'c.required',
                    'c.save_status',
                    'c.instruction'
                )
                ->distinct()
                ->orderBy('c.parent_video_upload_id')
                ->orderBy('c.enableflag')
                ->orderBy('ac.activity_id')
                ->orderBy('ad.activity_description_id')
                ->get();
                
            $currentactivity = DB::table('activity_initiation as a')
                ->join('activity as ac', 'ac.activity_id', '=', 'a.activity_id')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->join('parent_video_upload as c', 'c.activity_initiation_id', '=', 'a.activity_initiation_id')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'c.activity_description_id')
                ->leftJoin('face_to_face_observation as ff', 'ff.parent_video_id', '=', 'c.parent_video_upload_id')
                ->where('b.user_id', $userID)
                ->whereIn('c.status', ['Submitted', 'Re-Sent'])
                ->where('c.enableflag', 0)
                ->select(
                    'save_status1', // This assumes the column exists in one of the tables (likely 'c')
                    'a.activity_id',
                    'c.f2f_flag',
                    'ff.*',
                    'c.enableflag',
                    'c.save_status',
                    'c.comments',
                    'a.activity_initiation_id',
                    'ac.activity_name',
                    'ad.description',
                    'a.last_modified_date',
                    'c.status',
                    'c.parent_video_upload_id',
                    'ad.activity_description_id',
                    'c.instruction',
                    'c.coordinator_observation',
                    'c.head_observation',
                    'c.physical_observation_name',
                    'c.physical_observation_result'
                )
                ->distinct()
                ->orderBy('c.enableflag')
                ->orderBy('ac.activity_id')
                ->orderBy('ad.activity_description_id')
                ->get();

            $active = $lastactivity[0]->activity_id ?? null;

            $comments = DB::table('latest_video_comments as lvc')
                ->join('activity_initiation as ai', 'lvc.activity_initiation_id', '=', 'ai.activity_initiation_id')
                ->where('ai.enrollment_id', $enNum)
                ->where('lvc.active_status', '!=', 'New')
                ->select('lvc.parent_video_upload_id', 'lvc.*')
                ->distinct()
                ->get();

            $video_link = DB::table('activity_parent_video_upload')
                ->whereIn('parent_video_upload_id', function ($query) use ($userID) {
                    $query->select('a.parent_video_upload_id')
                        ->from('parent_video_upload as a')
                        ->join('activity_parent_video_upload as b', 'a.parent_video_upload_id', '=', 'b.parent_video_upload_id')
                        ->join('enrollment_details as c', 'a.Enrollment_id', '=', 'c.enrollment_id')
                        ->where('c.user_id', $userID)
                        ->distinct();
                })
                ->get();


            $activity_materials = DB::table('activity_materials')->get();

            $activity_materials_mapping = DB::table('activity_materials_mapping')->get();

            $f2f_observation = DB::table('face_to_face_observation')->get();

            $lastactivity1 = DB::select("SELECT DISTINCT  a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,c.instruction,
            c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            WHERE b.user_id='$userID' and c.status='Complete' ORDER BY c.parent_video_upload_id,c.enableflag ASC , ac.activity_id ASC , ad.activity_description_id");
            $activity_set = DB::select("SELECT aa.activity_id , aa.activity_name FROM activity AS aa");
            $datalist = DB::select("SELECT DISTINCT  a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.save_status , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,
            lv.comments as parent_comment,av.video_link,c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            INNER JOIN activity_parent_video_upload as av ON av.parent_video_upload_id = c.parent_video_upload_id
            LEFT JOIN latest_video_comments as lv on lv.parent_video_upload_id=c.parent_video_upload_id
            WHERE a.enrollment_id=$enNum and c.enableflag=0  GROUP BY ad.activity_description_id ORDER BY ac.activity_id ASC ");
            // Initialize an empty array to store the transformed data
            // Iterate through the query result
            $transformedData = [];
            foreach ($datalist as $data) {
                $activityName = $data->activity_name;

                // Remove the 'activity_name' from the data
                unset($data->activityName);

                // Check if the activity name already exists in the transformed data
                if (!isset($transformedData[$activityName])) {
                    $transformedData[$activityName] = [];
                }

                // Append the remaining data to the activity name key
                $transformedData[$activityName][] = (array)$data;
                $this->WriteFileLog(json_encode($data));
            }

            // Convert the transformed data to JSON format
            $jsonOutput = json_encode($transformedData, JSON_PRETTY_PRINT);
            // Remove newline characters from the JSON output
            $cleanedJsonString = str_replace("\n", "", $jsonOutput);


            $response = [
                'rows' => $rows,
                'lastactivity' => $lastactivity,
                'activity_set' => $activity_set,
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