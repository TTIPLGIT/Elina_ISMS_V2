<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AboveagemanagementController extends BaseController
{

    public function index(Request $request)
    {



        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compassobservation.index', compact('modules', 'screens'));
        //
    }

    public function sourcestrengthindex(Request $request)
    {


        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compassobservation.monthlyindex', compact('modules', 'screens'));
    }

    public function environmentstrengthindex(Request $request)
    {

        //dd("bjsc");

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compassobservation.tabview', compact('modules', 'screens'));
    }
    public function Migration_Thirteen_Plus()
    {
        try {

            $method = 'Method => AboveagemanagementController => Migration_Thirteen_Plus';

            // =====================================================
            // MENU DETAILS
            // =====================================================

            $menus   = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];


            // =====================================================
            // API CALL
            // =====================================================

            $gatewayURL = config('setting.api_gateway_url') . '/13_plus_migraton/index';

            $response = $this->serviceRequest(
                $gatewayURL,
                'GET',
                '',
                $method
            );

            $response = json_decode($response);

            $objData = json_decode(
                $this->decryptData($response->Data)
            );

            $response_data = json_decode(
                json_encode($objData->Data),
                true
            );


            // =====================================================
            // GET DATA
            // =====================================================

            $sail_status_details = $response_data['sail_status_details'] ?? [];
            $migration_to_13_plus = $response_data['migration_to_13_plus'] ?? [];
            $isms_migration_data = $response_data['isms_migration_data'] ?? [];
            $remigration_decision_list = $response_data['remigration_decision_list'] ?? [];
        
            return view(
                '13+QuestionCreation.13+_migration',
                compact(
                    'sail_status_details',
                    'migration_to_13_plus',
                    'isms_migration_data',
                    'remigration_decision_list',
                    'menus',
                    'screens',
                    'modules'
                )
            );
        } catch (\Exception $exc) {

            return $this->sendLog(
                $method,
                $exc->getCode(),
                $exc->getMessage(),
                $exc->getLine(),
                $exc->getTrace()[0]['args'][2] ?? ''
            );
        }
    }
    public function Store(Request $request)
    {
        try {

            $method = 'Method => AboveagemanagementController => Store';

            $migrationData = json_decode($request->migration_json, true);
            $data = [];

            $data['child_name']        = $migrationData['child_details']['name'] ?? null;

            $data['child_dob']         = $migrationData['child_details']['dob'] ?? null;

            $data['enrollment_id']     = $migrationData['child_details']['enrollment'] ?? null;

            $data['user_id']           = $migrationData['child_details']['user_id'] ?? null;

            $data['child_email']       = $migrationData['child_details']['email'] ?? null;

            $data['parent_name']       = $migrationData['parent_details']['parent_name'] ?? null;

            $data['coordinator_id']    = $migrationData['is_coordinator']['id'] ?? null;

            $data['coordinator_name']  = $migrationData['is_coordinator']['name'] ?? null;

            $data['coordinator_email'] = $migrationData['is_coordinator']['email'] ?? null;

            $data['notes'] = $migrationData['notes'] ?? null;

            $data['status'] = $migrationData['status'] ?? null;

            $data['migration_type'] = $request->migration_type ?? '13plus';

            $data['full_json']         = json_encode($migrationData);
            $encryptArray = $this->encryptData($data);

            $requestData = [];
            $requestData['requestData'] = $encryptArray;

            // dd($data);

            $gatewayURL = config('setting.api_gateway_url') . '/13plus/migration/store';

            $response = $this->serviceRequest(
                $gatewayURL,
                'POST',
                json_encode($requestData),
                $method
            );

            if (($request->migration_type ?? '') === '13plus') {
                $this->strapiMigrationStore($migrationData);
            }

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {

                return redirect()->back()->with(
                    'success',
                    'Child Transition Successfully'
                );
            } else {

                return redirect()->back()->with(
                    'fail',
                    'Something Went Wrong'
                );
            }
        } catch (\Exception $exc) {

            return redirect()->back()->with(
                'fail',
                $exc->getMessage()
            );
        }
    }

    public function MigrationRemigrate(Request $request)
    {
        try {

            $method = 'Method => AboveagemanagementController => MigrationRemigrate';

            $migrationData = json_decode($request->migration_json, true);

            $data = [
                'enrollment_id' => $migrationData['child_details']['enrollment'] ?? null,
                'notes' => $migrationData['notes'] ?? null,
            ];

            $encryptArray = $this->encryptData($data);

            $requestData = [];
            $requestData['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/13plus/migration/remigrate';

            $response = $this->serviceRequest(
                $gatewayURL,
                'POST',
                json_encode($requestData),
                $method
            );

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                return redirect()->back()->with(
                    'success',
                    'Child Remigrated to ISMS Successfully'
                );
            }

            return redirect()->back()->with(
                'fail',
                'Something Went Wrong'
            );
        } catch (\Exception $exc) {

            return redirect()->back()->with(
                'fail',
                $exc->getMessage()
            );
        }
    }

    public function MigrationDelete(Request $request)
    {
        try {

            $method = 'Method => AboveagemanagementController => MigrationDelete';

            $data = [
                'user_id' => $request->user_id,
                'enrollment' => $request->enrollment ?? $request->enrollment_id,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/13plus/migration/delete';

            $response = $this->serviceRequest(
                $gatewayURL,
                'POST',
                json_encode($data),
                $method
            );

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success && ($response->Code ?? null) == 200) {
                return response()->json([
                    'success' => true,
                    'message' => 'Migration deleted successfully',
                    'data' => json_decode(json_encode($response->Data ?? null), true),
                ]);
            }

            if (($response->Code ?? null) == 404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Migration record not found',
                ], 404);
            }

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 400);
        } catch (\Exception $exc) {

            return response()->json([
                'success' => false,
                'message' => $exc->getMessage(),
            ], 500);
        }
    }
}
