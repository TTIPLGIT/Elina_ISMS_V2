    public function data_edit($id)
    {
        try {

            $method = 'Method => activityInitiationController => data_edit';
            $id = $this->DecryptData($id);
            $authID = auth()->user()->id;
            $rows = DB::select("SELECT ques.enrollment_id, ques.activity_initiation_id, qud.user_id AS userID , qud.enrollment_child_num , qud.child_id , qud.child_name , question.activity_name , ques.status , ques.last_modified_date FROM activity_initiation AS ques INNER JOIN enrollment_details AS qud ON ques.enrollment_id=qud.enrollment_id INNER JOIN 
            activity AS question ON question.activity_id=ques.activity_id INNER JOIN users AS us ON us.id=ques.user_id WHERE ques.activity_initiation_id=$id");
            $enNum = $rows[0]->enrollment_id;
            $activity = DB::select("SELECT aa.activity_id , aa.activity_name , a.activity_initiation_id FROM activity_initiation AS a
            INNER JOIN activity AS aa ON aa.activity_id = a.activity_id
            WHERE a.enrollment_id=$enNum AND (action_flag != 1 OR action_flag IS NULL)");
            $activityshow = DB::select("SELECT * FROM activity_initiation AS ques INNER JOIN activity_description AS qud ON ques.activity_id=qud.activity_id  WHERE ques.activity_initiation_id=$id");
            $userID = $rows[0]->userID;
            $lastactivity = DB::select("SELECT DISTINCT  a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,
            c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result,c.required,c.save_status,c.instruction FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            WHERE b.user_id='$userID' ORDER BY c.parent_video_upload_id,c.enableflag ASC , ac.activity_id ASC , ad.activity_description_id");
            $currentactivity = DB::select("SELECT DISTINCT save_status1, a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.save_status , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,c.instruction,
            c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            WHERE b.user_id='$userID' AND (c.status = 'Submitted' OR c.status = 'Re-Sent')and c.enableflag=0 ORDER BY c.enableflag ASC , ac.activity_id ASC , ad.activity_description_id");
            $active = $lastactivity[0]->activity_id;
            $comments = DB::select("SELECT DISTINCT lvc.parent_video_upload_id, lvc.* FROM latest_video_comments as lvc
            JOIN activity_initiation as ai ON lvc.activity_initiation_id = ai.activity_initiation_id
            WHERE ai.enrollment_id =  $enNum and lvc.active_status !='New'");
            $video_link = DB::select("SELECT * FROM activity_parent_video_upload WHERE parent_video_upload_id IN(SELECT distinct a.parent_video_upload_id  FROM parent_video_upload AS a
            INNER JOIN activity_parent_video_upload AS b ON a.parent_video_upload_id=b.parent_video_upload_id
            INNER JOIN enrollment_details AS c ON  a.Enrollment_id=c.enrollment_id
            WHERE c.user_id=$userID)");

            $activity_materials = DB::select("select * from activity_materials");
            $activity_materials_mapping = DB::select("select * from activity_materials_mapping");
            $f2f_observation = DB::select("select * from face_to_face_observation");

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
                'activity' => $activity,
                'activityshow' => $activityshow,
                'lastactivity' => $lastactivity,
                'comments' => $comments,
                'video_link' => $video_link,
                'currentactivity' => $currentactivity,
                'activity_materials_mapping' => $activity_materials_mapping,
                'activity_materials' => $activity_materials,
                'f2f_observation' => $f2f_observation,
                'lastactivity1' => $lastactivity1,
                'datalist' => $cleanedJsonString,
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