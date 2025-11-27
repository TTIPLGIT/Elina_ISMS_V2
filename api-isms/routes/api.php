<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/registered/schools', [\App\Http\Controllers\WebpageController::class, 'getSchoolsRegistration']);
Route::post('/submitDenial', [\App\Http\Controllers\SaildocumentController::class, 'submitDenial']);
Route::post('/signedLogin', [\App\Http\Controllers\AuthController::class, 'signedLogin']);
Route::post('/signedLoginSub', [\App\Http\Controllers\AuthController::class, 'signedLoginSub']);
Route::post('/signedLoginSail', [\App\Http\Controllers\AuthController::class, 'signedLoginSail']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'Login']);
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/Register/screenapl', [\App\Http\Controllers\UserController::class, 'registerapl']);
Route::get('/Register/expcreate', [\App\Http\Controllers\UserController::class, 'expcreate']);
Route::get('/Register/educreate', [\App\Http\Controllers\UserController::class, 'educreate']);
Route::post('/master/storequestion', [\App\Http\Controllers\questionmastercontroller::class, 'store']);
Route::get('/beforeenrollment/createdata', [\App\Http\Controllers\EnrollementController::class, 'createdata']);
Route::post('/beforeenrollment/storedata', [\App\Http\Controllers\EnrollementController::class, 'storedata']);
Route::post('/v1/beforeenrollment/storedata', [\App\Http\Controllers\EnrollementController::class, 'storedata_v1']);
Route::get('/schoolenrollment/createdata', [\App\Http\Controllers\SchoolenrollmentController::class, 'createdata']);
Route::post('/schoolenrollment/storedata', [\App\Http\Controllers\SchoolenrollmentController::class, 'storedata']);
Route::post('/register/store', [\App\Http\Controllers\AuthController::class, 'registerstore']);
Route::post('/user_general/store', [\App\Http\Controllers\UserController::class, 'generalstore']);
Route::post('/user_general/updatedata', [\App\Http\Controllers\UserController::class, 'generalupdate']);
Route::post('/user_general/updatedynamicdata', [\App\Http\Controllers\UserController::class, 'updatedynamic']);
Route::post('/user_general/updatedynamicdata1', [\App\Http\Controllers\UserController::class, 'updatedynamic1']);
Route::post('/user_general/storedynamic', [\App\Http\Controllers\UserController::class, 'storedynamic']);
Route::post('/user_general/storedynamic1', [\App\Http\Controllers\UserController::class, 'storedynamic1']);
Route::post('/user_general/storeeqans', [\App\Http\Controllers\UserController::class, 'storeeqans']);
Route::post('/user_general/updateeqans', [\App\Http\Controllers\UserController::class, 'updateeqans']);
Route::post('/user_general/deleteeqans', [\App\Http\Controllers\UserController::class, 'deleteeqans']);
Route::post('/user_general/deletegen', [\App\Http\Controllers\UserController::class, 'deletegen']);
Route::post('/user_general/deleteexp', [\App\Http\Controllers\UserController::class, 'deleteexp']);
Route::post('/user_general/deleteedu', [\App\Http\Controllers\UserController::class, 'deleteedu']);

Route::post('/user/reset_password', [\App\Http\Controllers\UserController::class, 'reset_password']);

Route::get('/user/reset/{id}', [\App\Http\Controllers\UserController::class, 'reset']);

Route::post('/user/forget_password', [\App\Http\Controllers\UserController::class, 'forget_password']);

Route::post('/user/change_password_save', [\App\Http\Controllers\UserController::class, 'change_password_save']);

Route::get('/FAQ_questions_ans/get_faq_data', [\App\Http\Controllers\FAQmodulesController::class, 'get_faq_data']);

Route::post('/FAQ_questions_ans/get_search_ques', [\App\Http\Controllers\FAQmodulesController::class, 'get_search_ques']);

Route::post('/FAQ_questions_ans/get_search_ans', [\App\Http\Controllers\FAQmodulesController::class, 'get_search_ans']);

Route::get('/privacy/policy_screen', [\App\Http\Controllers\PrivacyPolicyController::class, 'policy_screen']);

Route::get('/login/background', [\App\Http\Controllers\PrivacyPolicyController::class, 'login_bg']);
Route::post('/userregisterfee/storedata', [\App\Http\Controllers\UserregisterfeeController::class, 'storedata']);
Route::POST('/service/provider/createdata', [\App\Http\Controllers\ServiceProviderController::class, 'createdata']);
Route::post('/serviveprovider/storedata', [\App\Http\Controllers\EnrollementController::class, 'serviveprovider']);
Route::post('/internship/storedata', [\App\Http\Controllers\EnrollementController::class, 'internship']);
Route::get('/referal/accept/{id}', [\App\Http\Controllers\ReferralReportController::class, 'referral_accept']);
Route::post('validate/enrollment/user', [\App\Http\Controllers\EnrollementController::class, 'ValidateEnrollment']);

// Web Portal

Route::post('/newsletter/schedule/phone', [App\Http\Controllers\Elina_webportalController::class, 'schedule_phone']);
Route::post('/newsletter/schedule/meeting', [App\Http\Controllers\Elina_webportalController::class, 'schedule_meeting']);
Route::post('/mayi_helpyou/mail', [App\Http\Controllers\Elina_webportalController::class, 'help_you']);
Route::post('/blog/comment/mail', [App\Http\Controllers\Elina_webportalController::class, 'blog_comment']);
Route::post('/events/registration', [App\Http\Controllers\Elina_webportalController::class, 'events_registration']);

Route::post('/user/generatedotp', [\App\Http\Controllers\MobileAPIController::class, 'generatedotp']);
Route::get('/user/VerifyOTP', [\App\Http\Controllers\MobileAPIController::class, 'VerifyOTP']);

// Previous year data Migration
Route::post('/Elina/data_migration', [\App\Http\Controllers\DataMigrationController::class, 'data_migration']);

// Previous year data Migration
Route::post('/Elina/data_migration', [\App\Http\Controllers\DataMigrationController::class, 'data_migration']);

// Key
Route::get('/update/editorKey/{id}', [\App\Http\Controllers\SettingsController::class, 'updateEditorKey']);
Route::get('/settings/tinymce', [\App\Http\Controllers\SettingsController::class, 'TinyMce']);
Route::post('/update-tinymce-status', [\App\Http\Controllers\SettingsController::class, 'TinyMceUpdateStatus']);
Route::post('/add-tinymce-record', [\App\Http\Controllers\SettingsController::class, 'TinyMceAddRecord']);

Route::middleware('auth:api')->group(function () {

  Route::get('/login/user', [\App\Http\Controllers\UserController::class, 'User']);
  Route::get('/check/user/session', [\App\Http\Controllers\AuthController::class, 'checkSession']);
  // uam_modules
  Route::get('/uam_modules/get_data', [\App\Http\Controllers\UamModulesController::class, 'get_data']);
  Route::get('/uam_modules/get_uam_modules', [\App\Http\Controllers\UamModulesController::class, 'get_uam_modules']);
  Route::get('/uam_modules/data_delete/{id}', [\App\Http\Controllers\UamModulesController::class, 'data_delete']);
  Route::get('/uam_modules/data_edit/{id}', [\App\Http\Controllers\UamModulesController::class, 'data_edit']);
  Route::post('/uam_modules/storedata', [\App\Http\Controllers\UamModulesController::class, 'storedata']);
  Route::post('/uam_modules/updatedata', [\App\Http\Controllers\UamModulesController::class, 'updatedata']);
  //dashboard
  Route::get('user/dashboard', [\App\Http\Controllers\homecontroller::class, 'index']);
  Route::get('/user/status/view', [\App\Http\Controllers\homecontroller::class, 'status_view']);
  Route::get('/search/Coordinators/view', [\App\Http\Controllers\homecontroller::class, 'searchCoordinators']);
  //userregisterfeecontroller
  Route::get('/userregisterfee/index', [\App\Http\Controllers\UserregisterfeeController::class, 'index']);
  Route::get('/userregisterfee/createdata', [\App\Http\Controllers\UserregisterfeeController::class, 'createdata']);
  // Route::post('/userregisterfee/storedata', [\App\Http\Controllers\UserregisterfeeController::class, 'storedata']);
  Route::get('/userregisterfee/data_edit/{id}', [\App\Http\Controllers\UserregisterfeeController::class, 'data_edit']);
  Route::post('/userregisterfee/updatedata', [\App\Http\Controllers\UserregisterfeeController::class, 'updatedata']);
  Route::get('/userregisterfee/data_delete/{id}', [\App\Http\Controllers\UserregisterfeeController::class, 'data_delete']);
  Route::post('/offline/payment/complete', [\App\Http\Controllers\UserregisterfeeController::class, 'completepayment']);
  // ovm1_screen
  Route::get('/ovm1/index', [\App\Http\Controllers\ovm1Controller::class, 'index']);
  Route::get('/g2form/list/view', [\App\Http\Controllers\ovm1Controller::class, 'g2form_list']);
  Route::get('/g2form/getdata/{id}', [\App\Http\Controllers\ovm1Controller::class, 'g2form_data']);
  Route::post('/g2form/storedata', [\App\Http\Controllers\ovm1Controller::class, 'g2form_storedata']);
  Route::get('/ovm1/create', [\App\Http\Controllers\ovm1Controller::class, 'create']);
  Route::post('/ovm1/store', [\App\Http\Controllers\ovm1Controller::class, 'store']);
  Route::get('/ovm1/data_edit/{id}', [\App\Http\Controllers\ovm1Controller::class, 'data_edit']);
  Route::get('/ovm1/completed_data_edit/{id}', [\App\Http\Controllers\ovm1Controller::class, 'completed_data_edit']);
  Route::get('/ovm1/completedisedit_data_edit/{id}', [\App\Http\Controllers\ovm1Controller::class, 'completedisedit_data_edit']);
  Route::get('/ovm1/completed_isedit_data_edit/{id}/{meet}', [\App\Http\Controllers\ovm1Controller::class, 'completed_isedit_data_edit']);
  Route::get('/ovm1/feedbacksubmit/{id}', [\App\Http\Controllers\ovm1Controller::class, 'feedbacksubmit']);
  Route::post('/ovm1/updatedata', [\App\Http\Controllers\ovm1Controller::class, 'updatedata']);
  Route::get('/ovm1/data_delete/{id}', [\App\Http\Controllers\ovm1Controller::class, 'data_delete']);
  Route::get('/ovm1/meetinginvite', [\App\Http\Controllers\ovm1Controller::class, 'meetinginvite']);
  Route::get('/ovm2/meetinginvite', [\App\Http\Controllers\ovm1Controller::class, 'meetinginvite2']);
  Route::get('/ovm1/getchilddetails/{id}', [\App\Http\Controllers\UamScreensController::class, 'getchilddetails']);
  Route::post('/ovmiscfeedback/store', [\App\Http\Controllers\ovm1Controller::class, 'ovmiscfeedbackstore']);
  Route::post('/ovmisc_feedback/update', [\App\Http\Controllers\ovm1Controller::class, 'ovmiscfeedback_update']);
  Route::get('/ovm1/ovmmeetingcompleted', [\App\Http\Controllers\ovm1Controller::class, 'ovmmeetingcompleted']);
  Route::get('/ovm1/ovmreport', [\App\Http\Controllers\ovm1Controller::class, 'ovmreport']);
  Route::get('/ovm1/ovmreportview', [\App\Http\Controllers\ovm1Controller::class, 'ovmreportview']);
  Route::post('/report/assessment', [\App\Http\Controllers\ovm1Controller::class, 'report_sent']);
  Route::post('/report/ovm/report', [\App\Http\Controllers\ovm1Controller::class, 'ovm_report_download']);
  Route::post('ovm/template/store', [\App\Http\Controllers\ovm1Controller::class, 'ovm_template_store']);
  Route::post('/sail/guide/save', [\App\Http\Controllers\ovm1Controller::class, 'SailguideSave']);
  Route::get('ovm/template/getdata/{id}', [\App\Http\Controllers\ovm1Controller::class, 'ovm_template_getdata']);
  // ovm2_screen
  Route::get('/ovm2/index', [\App\Http\Controllers\ovm2Controller::class, 'index']);
  Route::get('/ovm2/create', [\App\Http\Controllers\ovm2Controller::class, 'create']);
  Route::post('/ovm2/store', [\App\Http\Controllers\ovm2Controller::class, 'store']);
  Route::get('/ovm2/data_edit/{id}', [\App\Http\Controllers\ovm2Controller::class, 'data_edit']);
  Route::post('/ovm2/updatedata', [\App\Http\Controllers\ovm2Controller::class, 'updatedata']);
  Route::get('/ovm2/data_delete/{id}', [\App\Http\Controllers\ovm2Controller::class, 'data_delete']);
  Route::get('/ovm2/data_delete/{id}', [\App\Http\Controllers\ovm2Controller::class, 'data_delete']);
  // uam_screens
  Route::get('/uam_screens/get_data', [\App\Http\Controllers\UamScreensController::class, 'get_data']);
  Route::get('/uam_screens/getscreenpermission/{id}', [\App\Http\Controllers\UamScreensController::class, 'getscreenpermission']);
  Route::get('/uam_screens/get_work_flow_data', [\App\Http\Controllers\UamScreensController::class, 'get_work_flow_data']);
  Route::get('/uam_screens/data_delete/{id}', [\App\Http\Controllers\UamScreensController::class, 'data_delete']);
  Route::get('/uam_screens/data_edit/{id}', [\App\Http\Controllers\UamScreensController::class, 'data_edit']);
  Route::post('/uam_screens/storedata', [\App\Http\Controllers\UamScreensController::class, 'storedata']);
  Route::post('/uam_screens/updatedata', [\App\Http\Controllers\UamScreensController::class, 'updatedata']);
  // uam_modules_screens
  Route::get('/uam_modules_screens/get_data', [\App\Http\Controllers\UamModulesScreensController::class, 'get_data']);
  Route::get('/uam_modules_screens/get_modules_screen/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'get_modules_screen']);
  Route::get('/uam_modules_screens/getmodulesandscreens', [\App\Http\Controllers\UamModulesScreensController::class, 'getmodulesandscreens']);
  Route::get('/uam_modules_screens/data_delete/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'data_delete']);
  Route::get('/uam_modules_screens/data_edit/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'data_edit']);
  Route::post('/uam_modules_screens/storedata', [\App\Http\Controllers\UamModulesScreensController::class, 'storedata']);
  Route::post('/uam_modules_screens/updatedata', [\App\Http\Controllers\UamModulesScreensController::class, 'updatedata']);
  Route::post('/uam_modules_screens/screen_data_get', [\App\Http\Controllers\UamModulesScreensController::class, 'screen_data_get']);
  Route::post('/uam_modules_screens/get_sub_module', [\App\Http\Controllers\UamModulesScreensController::class, 'get_sub_module']);
  //dynamiclist
  Route::get('/dynamic_list/getallscreens', [\App\Http\Controllers\DynamicController::class, 'getallscreens']);
  Route::post('/dynamicfieldallocation/storedata', [\App\Http\Controllers\DynamicController::class, 'storedata']);
  Route::get('/dynamiclist/get_data', [\App\Http\Controllers\DynamicController::class, 'get_data']);
  Route::get('/dynamiclist/data_edit/{id1}', [\App\Http\Controllers\DynamicController::class, 'data_edit']);
  Route::post('/dynamiclist/update_data', [\App\Http\Controllers\DynamicController::class, 'update_data']);
  Route::get('/dynamic_list_allocation/getallscreens', [\App\Http\Controllers\DynamicListController::class, 'getallscreens']);
  Route::post('/dynamicallocationlist/storedata', [\App\Http\Controllers\DynamicListController::class, 'storedata']);
  Route::get('/getalldynamicfield', [\App\Http\Controllers\DynamicListController::class, 'getalldynamicfield']);
  Route::get('/dynamiclistallocation/get_data', [\App\Http\Controllers\DynamicListController::class, 'get_data']);
  Route::get('/dynamiclistallocation/data_edit/{id1}/{id2}', [\App\Http\Controllers\DynamicListController::class, 'data_edit']);
  Route::get('/dynamiclistallocation/data_delete/{id1}/{id2}', [\App\Http\Controllers\DynamicListController::class, 'data_delete']);
  Route::post('/dynamiclistallocation/update_data', [\App\Http\Controllers\DynamicListController::class, 'update_data']);
  Route::get('/dynamiclist/data_delete/{id}', [\App\Http\Controllers\DynamicController::class, 'data_delete']);
  Route::get('/get/module', [\App\Http\Controllers\DynamicListController::class, 'getmodule']);
  // uam_roles
  Route::get('/uam_roles/get_data', [\App\Http\Controllers\UamRolesController::class, 'get_data']);
  Route::get('/uam_roles/get_roles_screen/{id}', [\App\Http\Controllers\UamRolesController::class, 'get_roles_screen']);
  Route::get('/uam_roles/getmodulesandscreens', [\App\Http\Controllers\UamRolesController::class, 'getmodulesandscreens']);
  Route::get('/uam_roles/data_delete/{id}', [\App\Http\Controllers\UamRolesController::class, 'data_delete']);
  Route::get('/uam_roles/data_edit/{id}', [\App\Http\Controllers\UamRolesController::class, 'data_edit']);
  Route::post('/uam_roles/storedata', [\App\Http\Controllers\UamRolesController::class, 'storedata']);
  Route::post('/uam_roles/updatedata', [\App\Http\Controllers\UamRolesController::class, 'updatedata']);
  // user
  Route::get('/user/get_user_list', [\App\Http\Controllers\UserController::class, 'get_user_list']);
  Route::get('/user/reset_expire_data_get', [\App\Http\Controllers\UserController::class, 'reset_expire_data_get']);
  Route::get('/user/department_list', [\App\Http\Controllers\UserController::class, 'department_list']);
  Route::get('/user/project_roles_list', [\App\Http\Controllers\UserController::class, 'project_roles_list']);
  Route::post('/user/token_expire_data_update', [\App\Http\Controllers\UserController::class, 'token_expire_data_update']);
  Route::post('/user/update_toggle', [\App\Http\Controllers\UserController::class, 'update_toggle']);
  Route::post('/user/get_department_list', [\App\Http\Controllers\UserController::class, 'get_department_list']);
  Route::get('/user/get_roles_list', [\App\Http\Controllers\UserController::class, 'get_roles_list']);
  Route::post('/user/user_register', [\App\Http\Controllers\UserController::class, 'user_register']);
  Route::get('/user/data_edit/{id}', [\App\Http\Controllers\UserController::class, 'data_edit']);
  Route::get('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
  Route::post('/user/updatedata', [\App\Http\Controllers\UserController::class, 'updatedata']);
  Route::post('/user/updatedatapermission', [\App\Http\Controllers\UserController::class, 'updatedatapermission']);
  Route::get('/user/edit_permission/{id}', [\App\Http\Controllers\UserController::class, 'edit_permission']);
  Route::post('/user/notifications', [\App\Http\Controllers\UserController::class, 'notifications']);
  Route::post('/user/notification_alert', [\App\Http\Controllers\UserController::class, 'notification_alert']);
  Route::post('/user/profilepage', [\App\Http\Controllers\UserController::class, 'profilepage']);
  Route::post('/user/profile_update', [\App\Http\Controllers\UserController::class, 'profile_update']);
  Route::get('/auditlog/search', [\App\Http\Controllers\AuditlogController::class, 'get_data']);
  Route::post('/auditlog/user_id', [\App\Http\Controllers\AuditlogController::class, 'user_id']);
  Route::post('/auditlog/search', [\App\Http\Controllers\AuditlogController::class, 'Search']);
  Route::get('/auditlog/login', [\App\Http\Controllers\AuditlogController::class, 'get_login']);
  Route::post('/auditlog/login', [\App\Http\Controllers\AuditlogController::class, 'login_search']);
  Route::get('/uam_data/menu_data', [\App\Http\Controllers\UamDataController::class, 'menu_data']);
  // faq_modules
  Route::get('/FAQ_modules/get_data', [\App\Http\Controllers\FAQmodulesController::class, 'get_data']);
  Route::get('/FAQ_modules/get_FAQ_modules', [\App\Http\Controllers\FAQmodulesController::class, 'get_FAQ_modules']);
  Route::get('/FAQ_modules/data_delete/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'data_delete']);
  Route::get('/FAQ_modules/data_edit/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'data_edit']);
  Route::post('/FAQ_modules/storedata', [\App\Http\Controllers\FAQmodulesController::class, 'storedata']);
  Route::post('/FAQ_modules/updatedata', [\App\Http\Controllers\FAQmodulesController::class, 'updatedata']);
  // designation
  Route::get('/designation/get_data', [\App\Http\Controllers\DesignationController::class, 'get_data']);
  Route::get('/designation/get_designation', [\App\Http\Controllers\DesignationController::class, 'get_designation']);
  Route::get('/designation/data_delete/{id}', [\App\Http\Controllers\DesignationController::class, 'data_delete']);
  Route::get('/designation/data_edit/{id}', [\App\Http\Controllers\DesignationController::class, 'data_edit']);
  Route::post('/designation/storedata', [\App\Http\Controllers\DesignationController::class, 'storedata']);
  Route::post('/designation/updatedata', [\App\Http\Controllers\DesignationController::class, 'updatedata']);
  //bulk_upload
  Route::post('/document_category/bulkdummyupload', [\App\Http\Controllers\UserController::class, 'bulkdummyupload']);
  Route::post('/document_category/checking_data', [\App\Http\Controllers\UserController::class, 'checking_data']);
  // faq_question
  Route::get('/FAQ_questions/get_data', [\App\Http\Controllers\FAQquestionsController::class, 'get_data']);
  Route::get('/FAQ_questions/get_FAQ_questions', [\App\Http\Controllers\FAQquestionsController::class, 'get_FAQ_questions']);
  Route::get('/FAQ_questions/data_delete/{id}', [\App\Http\Controllers\FAQquestionsController::class, 'data_delete']);
  Route::get('/FAQ_questions/data_edit/{id}', [\App\Http\Controllers\FAQquestionsController::class, 'data_edit']);
  Route::post('/FAQ_questions/storedata', [\App\Http\Controllers\FAQquestionsController::class, 'storedata']);
  Route::post('/FAQ_questions/updatedata', [\App\Http\Controllers\FAQquestionsController::class, 'updatedata']);
  Route::post('/FAQ_questions/update_toggle', [\App\Http\Controllers\FAQquestionsController::class, 'update_toggle']);
  //profile
  Route::get('/privacy/update/{id}', [\App\Http\Controllers\PrivacyPolicyController::class, 'index']);
  Route::post('/privacy/publish', [\App\Http\Controllers\PrivacyPolicyController::class, 'publish']);
  Route::get('/image/upload/{id}', [\App\Http\Controllers\PrivacyPolicyController::class, 'upload']);
  Route::post('/image/publish', [\App\Http\Controllers\PrivacyPolicyController::class, 'imagepublish']);
  Route::post('/background/image', [\App\Http\Controllers\PrivacyPolicyController::class, 'backgroundimage']);
  //Reports
  Route::get('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'get_data']);
  Route::post('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'Search']);
  Route::get('/auditlog/login_report', [\App\Http\Controllers\ReportController::class, 'get_login']);
  Route::post('/auditlog/login_report', [\App\Http\Controllers\ReportController::class, 'login_search']);
  Route::get('/reports/userrole', [\App\Http\Controllers\ReportController::class, 'get_userrole']);
  Route::post('/reports/userrole', [\App\Http\Controllers\ReportController::class, 'userrole_search']);
  Route::get('/reports/processflow', [\App\Http\Controllers\ReportController::class, 'get_process']);
  Route::post('/reports/processflow', [\App\Http\Controllers\ReportController::class, 'process_search']);
  Route::get('/reports/added_doc', [\App\Http\Controllers\ReportController::class, 'get_newdoc']);
  Route::post('/reports/added_doc', [\App\Http\Controllers\ReportController::class, 'newdoc_search']);
  Route::get('/reports/deleted_doc', [\App\Http\Controllers\ReportController::class, 'get_deletedoc']);
  Route::post('/reports/deleted_doc', [\App\Http\Controllers\ReportController::class, 'deletedoc_search']);
  Route::get('/reports/archive_doc', [\App\Http\Controllers\ReportController::class, 'get_archivedoc']);
  Route::post('/reports/archive_doc', [\App\Http\Controllers\ReportController::class, 'archivedoc_search']);
  Route::get('/reports/process_doc', [\App\Http\Controllers\ReportController::class, 'get_processedoc']);
  Route::post('/reports/process_doc', [\App\Http\Controllers\ReportController::class, 'processdoc_search']);
  Route::get('/reports/grouped_count', [\App\Http\Controllers\ReportController::class, 'get_grouped']);
  Route::post('/reports/grouped_count', [\App\Http\Controllers\ReportController::class, 'grouped_search']);
  Route::get('/reports/awaiting_auth', [\App\Http\Controllers\ReportController::class, 'get_awaiting_auth']);
  Route::post('/reports/awaiting_auth', [\App\Http\Controllers\ReportController::class, 'awaiting_auth_search']);
  //
  Route::get('/uam_data/fillscreensbasedonuser/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedonuser']);
  Route::get('/uam_data/filldynamiclist/{id}', [\App\Http\Controllers\UamDataController::class, 'filldynamiclist']);
  Route::get('/uam_data/fillscreensbasedondash/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedondash']);
  Route::get('/uam_data/fillscreensbasedondocument/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedondocument']);
  //question_master
  Route::get('/Questionmaster/index', [\App\Http\Controllers\questionmastercontroller::class, 'index']);
  Route::get('/master/data_delete/{id}', [\App\Http\Controllers\questionmastercontroller::class, 'data_delete']);
  Route::get('/Questionmaster/data_edit/{id}', [\App\Http\Controllers\questionmastercontroller::class, 'data_edit']);
  Route::post('/Questionmaster/updatedata', [\App\Http\Controllers\questionmastercontroller::class, 'updatedata']);
  //Newenrollement
  Route::get('/newenrollment/index', [\App\Http\Controllers\NewenrollementController::class, 'index']);
  Route::post('/newenrollment/storedata', [\App\Http\Controllers\NewenrollementController::class, 'storedata']);
  Route::get('/newenrollment/createdata', [\App\Http\Controllers\NewenrollementController::class, 'createdata']);
  Route::get('/newenrollment/data_edit/{id}', [\App\Http\Controllers\NewenrollementController::class, 'data_edit']);
  Route::get('/lead/syj/view/{id}', [\App\Http\Controllers\NewenrollementController::class, 'syj_getdata']);
  Route::post('/newenrollment/updatedata', [\App\Http\Controllers\NewenrollementController::class, 'updatedata']);
  Route::post('/v2/newenrollment/updatedata', [\App\Http\Controllers\NewenrollementController::class, 'updatedata_v2']);
  Route::get('/newenrollment/data_delete/{id}', [\App\Http\Controllers\NewenrollementController::class, 'data_delete']);
  //intern and service provider
  Route::get('/newenrollment/internlist', [\App\Http\Controllers\NewenrollementController::class, 'internlist']);
  Route::get('/newenrollment/servicelist', [\App\Http\Controllers\NewenrollementController::class, 'servicelist']);
  Route::get('/internview/data_edit/{id}', [\App\Http\Controllers\NewenrollementController::class, 'internview_data_edit']);
  Route::get('/serviceproviderview/data_edit/{id}', [\App\Http\Controllers\NewenrollementController::class, 'serviceproviderview_data_edit']);

  //ajax 
  Route::post('/userregisterfee/enrollmentlist', [\App\Http\Controllers\UserregisterfeeController::class, 'GetAllDepartmentsByDirectorate']);
  Route::post('/sensory/enrollmentlist', [\App\Http\Controllers\UserregisterfeeController::class, 'SensoryGetData']);
  Route::post('/sail/category_data_get', [\App\Http\Controllers\UserregisterfeeController::class, 'category_data_get']);
  Route::post('/sail/GetIsCo', [\App\Http\Controllers\UserregisterfeeController::class, 'GetIsCo']);
  Route::post('/parentvideo/description', [\App\Http\Controllers\ParentvideouploadController::class, 'Getdescription']);
  Route::post('/parentvideo/materials', [\App\Http\Controllers\ParentvideouploadController::class, 'Getmaterials']);
  Route::post('/parentvideo/f2fdescription', [\App\Http\Controllers\ParentvideouploadController::class, 'f2f_description']);

  Route::post('/elinaleadsearch/dashboard', [\App\Http\Controllers\homecontroller::class, 'elinaleadsearch']);
  Route::post('/activityinitiate/ajax', [\App\Http\Controllers\activityInitiationController::class, 'activityajax']);
  //paymentcontroller
  Route::get('/payment/index', [\App\Http\Controllers\Paymentcontroller::class, 'index']);
  Route::get('/payment/create_data/{id}', [\App\Http\Controllers\Paymentcontroller::class, 'createdata']);
  Route::post('/payment/offline/request', [\App\Http\Controllers\Paymentcontroller::class, 'offline_request']);
  Route::get('/payment/createdata', [\App\Http\Controllers\Paymentcontroller::class, 'createdata'])->name('payuserfee.create');
  Route::get('/payment/createdata1/{id}', [\App\Http\Controllers\Paymentcontroller::class, 'createdata1'])->name('payuserfee.create1');
  Route::get('/signed/form/url', [\App\Http\Controllers\SaildocumentController::class, 'CreatSignedURL']);
  Route::get('/questionnaire/signed/form/{id}', [\App\Http\Controllers\SaildocumentController::class, 'SignedQuestionnaire']);
  Route::post('/signed/form/email', [\App\Http\Controllers\SaildocumentController::class, 'CreatSignedEmail']);
  Route::post('/payment/storedata', [\App\Http\Controllers\Paymentcontroller::class, 'storedata']);
  Route::post('/payment/storedata/email', [\App\Http\Controllers\Paymentcontroller::class, 'storedataemail']);
  Route::get('/payment/data_edit/{id}', [\App\Http\Controllers\UserregisterfeeController::class, 'data_edit']);
  //after enrollment
  Route::get('/schoolenrollment/index', [\App\Http\Controllers\SchoolenrollmentController::class, 'index']);
  Route::get('/schoolenrollment/data_edit/{id}', [\App\Http\Controllers\SchoolenrollmentController::class, 'data_edit']);
  Route::post('/schoolenrollment/updatedata', [\App\Http\Controllers\SchoolenrollmentController::class, 'updatedata']);

  Route::get('/Elinademo/index', [\App\Http\Controllers\ElinademoforparentsController::class, 'index']);
  Route::get('/Elinademo/create', [\App\Http\Controllers\ElinademoforparentsController::class, 'create']);
  Route::post('/Elinademo/store', [\App\Http\Controllers\ElinademoforparentsController::class, 'store']);
  Route::get('/Elinademo/data_edit/{id}', [\App\Http\Controllers\ElinademoforparentsController::class, 'data_edit']);
  Route::get('/Elinademo/completed_data_edit/{id}', [\App\Http\Controllers\ElinademoforparentsController::class, 'completed_data_edit']);
  Route::post('/Elinademo/updatedata', [\App\Http\Controllers\ElinademoforparentsController::class, 'updatedata']);
  Route::get('/Elinademo/data_delete/{id}', [\App\Http\Controllers\ElinademoforparentsController::class, 'data_delete']);
  Route::get('/Elinademo/meetinginvite', [\App\Http\Controllers\ElinademoforparentsController::class, 'meetinginvite']);
  Route::get('/Elinademo/getchilddetails/{id}', [\App\Http\Controllers\UamScreensController::class, 'getchilddetails']);
  Route::get('/Elinademo/ovmmeetingcompleted', [\App\Http\Controllers\ElinademoforparentsController::class, 'ovmmeetingcompleted']);
  Route::get('/Elinademo/ovmreport', [\App\Http\Controllers\ElinademoforparentsController::class, 'ovmreport']);
  Route::get('/Elinademo/ovmreportview', [\App\Http\Controllers\ElinademoforparentsController::class, 'ovmreportview']);
  //SAIL Document
  Route::get('/sail/index', [\App\Http\Controllers\SaildocumentController::class, 'index']);
  Route::get('/sail/sailstatus', [\App\Http\Controllers\SaildocumentController::class, 'sailstatus']);
  Route::get('/sail/questionnaireinitiate', [\App\Http\Controllers\SaildocumentController::class, 'questionnaireinitiate']);
  Route::get('/sail/initiate', [\App\Http\Controllers\SaildocumentController::class, 'SailInitiate']);
  Route::post('/sail/storedata', [\App\Http\Controllers\SaildocumentController::class, 'storedata']);
  Route::get('/sail/data_edit/{id}', [\App\Http\Controllers\SaildocumentController::class, 'data_edit']);
  Route::get('/sail/edit_data/{id}', [\App\Http\Controllers\SaildocumentController::class, 'edit_data']);
  Route::post('/sailcomplete/store', [\App\Http\Controllers\SaildocumentController::class, 'sailcomplete']);
  Route::post('/sail/updatedata', [\App\Http\Controllers\SaildocumentController::class, 'updatedata']);
  Route::get('/sail/data_delete/{id}', [\App\Http\Controllers\SaildocumentController::class, 'data_delete']);
  Route::post('/sail/getchildenrollment', [\App\Http\Controllers\SaildocumentController::class, 'GetAllDepartmentsByDirectorate']);
  Route::post('/sail/initiate/store', [\App\Http\Controllers\SaildocumentController::class, 'SailInitiateStore']);
  Route::post('/sail/reinitiate/store', [\App\Http\Controllers\SaildocumentController::class, 'SailReInitiateStore']);
  Route::get('/sail/sailquestionnaireinitiate', [\App\Http\Controllers\SaildocumentController::class, 'sailquestionnaireinitiate']);
  Route::get('/sail/sailquestionnairelistview', [\App\Http\Controllers\SaildocumentController::class, 'questionnaireindex']);
  Route::post('/sail/sailstoredata', [\App\Http\Controllers\SaildocumentController::class, 'sail_storedata']);
  Route::get('/sail/consent/form', [\App\Http\Controllers\SaildocumentController::class, 'getConsentDetails']);
  Route::post('/sail/consent/declined', [\App\Http\Controllers\SaildocumentController::class, 'SailConsentDecline']);
  //SAIL PAYMENT
  Route::get('userregisterfee/sailcreate', [\App\Http\Controllers\UserregisterfeeController::class, 'sailcreatedata']);
  Route::post('/userregisterfee/store_data', [\App\Http\Controllers\UserregisterfeeController::class, 'sailstoredata']);
  //Question Creation
  Route::post('/question_creation/storedata', [\App\Http\Controllers\QuestionCreationController::class, 'storedata']);
  Route::post('/question_creation/get_options', [\App\Http\Controllers\QuestionCreationController::class, 'get_options']);
  Route::get('/question_creation/getdata', [\App\Http\Controllers\QuestionCreationController::class, 'getdata']);
  Route::get('/question_creation/data_delete/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'data_delete']);
  Route::get('/question_creation/data_edit/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'data_edit']);
  Route::post('/question_creation/update_data', [\App\Http\Controllers\QuestionCreationController::class, 'update_data']);
  Route::post('/question_creation/store_question', [\App\Http\Controllers\QuestionCreationController::class, 'store_question']);
  Route::get('/question_creation/question_delete/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'question_delete']);
  Route::post('/question_creation/question_update', [\App\Http\Controllers\QuestionCreationController::class, 'question_update']);
  Route::get('/questionnaire_for_parents/editdata/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'data_edit']);
  Route::get('/questionnaire_for_parents/indexlist', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'index']);
  Route::post('/questionnaire/update_toggle', [\App\Http\Controllers\QuestionCreationController::class, 'update_toggle']);
  Route::get('/questionnaire/validation/type', [\App\Http\Controllers\QuestionCreationController::class, 'validation_type']);
  //parent_questionnaire
  Route::get('/questionnaire_for_parents/getdata', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'getdata']);
  Route::get('/questionnaire_parents/fields/list', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllQuestionnaireFields']);
  Route::get('/questionnaire/field/dropdown/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllDropdownOptions']);
  Route::get('/questionnaire/field/radio/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllRadioOptions']);
  Route::get('/questionnaire/field/checkbox/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllCheckBoxOptions']);
  Route::get('/questionnaire/field/subdropdown/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubQuestionDropdownBoxOptions']);
  Route::get('/questionnaire/field/subradio/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubQuestionRadioOptions']);
  Route::post('/questionnaire/form/submit', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'QuestionnaireFormSubmit']);
  Route::post('/questionnaire/form/save', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'QuestionnaireFormSave']);
  Route::get('/question_creation/viewdata/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'viewdata']);
  Route::post('/questionnaire/graph/getdata', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GraphGetdata']);

  //Questinnaire Master 
  Route::get('/questionnaire_master/search', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'search']);
  Route::post('/questionnaire_master/update_toggle', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'update_toggle']);
  Route::get('/questionnaire_master/data_edit/{id}', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'data_edit']);
  Route::post('/questionnaire_master/updatedata', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'updatedata']);
  Route::get('/questionnaire_master/data_delete/{id}', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'data_delete']);
  Route::post('/questionnaire_master/storedata', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'storedata']);
  Route::get('/questionnaire_master/directorate', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'directorate']);
  Route::get('/questionnaire_master/get_data', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'get_data']);
  Route::post('/questionnaire_master/department_category_get', [\App\Http\Controllers\QuestinnaireMasterCreation::class, 'department_category_get']);
  //
  Route::get('/questionnaire/submitted/list', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubmittedForm']);
  Route::get('/questionnaire/submitted/form/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'SubmittedForm']);
  Route::get('/questionnaire/sensoryreport/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'sensoryreport']);
  Route::get('/questionnaire/executive_report/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'executive_report']);

  //video upload creation
  Route::get('/videocreation/index', [\App\Http\Controllers\ParentvideouploadController::class, 'index']);
  Route::get('/videocreation/createdata', [\App\Http\Controllers\ParentvideouploadController::class, 'createdata']);
  Route::post('/videocreation/storedata', [\App\Http\Controllers\ParentvideouploadController::class, 'storedata']);
  Route::get('/videocreation/data_edit/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'data_edit']);
  Route::get('/master/videocreation/data_edit_1/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'data_edit_1']);
  Route::post('/videocreation/updatedata', [\App\Http\Controllers\ParentvideouploadController::class, 'updatedata']);
  Route::post('/activity/materials/mapping/store', [\App\Http\Controllers\ParentvideouploadController::class, 'mapping_update']);
  Route::get('/parentvideo/index', [\App\Http\Controllers\ParentvideouploadController::class, 'indexdata']);
  Route::get('/parentvideo/parent_createdata/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'parent_createdata']);
  // Route::get('/parentvideo/initiate', [\App\Http\Controllers\ParentvideouploadController::class, 'activity_creation']);
  Route::post('videocreation/parentstore', [\App\Http\Controllers\ParentvideouploadController::class, 'parent_storedata']);
  Route::post('/video/parent/reject/reupload/bulk', [\App\Http\Controllers\ParentvideouploadController::class, 'video_reupload']);
  Route::post('videocreation/parentstore/bulk', [\App\Http\Controllers\ParentvideouploadController::class, 'parent_storedata_bulk']);
  Route::post('videocreation/policyaggrement', [\App\Http\Controllers\ParentvideouploadController::class, 'policyaggrement']);
  Route::get('/activity/data_delete/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'delete']);
  Route::post('/video/creation/action', [\App\Http\Controllers\ParentvideouploadController::class, 'activityAction']);

  // Assessment Mapping
  Route::get('/assessment/mapping/index', [App\Http\Controllers\AssessmentMapping::class, 'index']);
  Route::get('/assessment/mapping/create', [App\Http\Controllers\AssessmentMapping::class, 'create']);
  Route::post('/assessment/mapping/store', [App\Http\Controllers\AssessmentMapping::class, 'store']);
  Route::post('/assessment/mapping/update', [App\Http\Controllers\AssessmentMapping::class, 'update']);
  Route::get('/assessment/mapping/edit', [App\Http\Controllers\AssessmentMapping::class, 'edit']);
  Route::post('/assessment/skill/getdetails', [\App\Http\Controllers\AssessmentMapping::class, 'GetDetails']);
  Route::post('/store/new/assessment/skill', [\App\Http\Controllers\AssessmentMapping::class, 'NewAssesmentSkill']);

  //activity initiation
  Route::get('/activityinitiate/index', [\App\Http\Controllers\activityInitiationController::class, 'index']);
  Route::get('/activityinitiate/create', [\App\Http\Controllers\activityInitiationController::class, 'createdata']);
  Route::post('/activityinitiate/storedata', [\App\Http\Controllers\activityInitiationController::class, 'storedata']);
  Route::get('/activityinitiate/data_edit/{id}', [\App\Http\Controllers\activityInitiationController::class, 'data_edit']);
  Route::post('/activityinitiate/updatedata', [\App\Http\Controllers\activityInitiationController::class, 'updatedata']);
  Route::post('/activityinitiate/update/video', [\App\Http\Controllers\activityInitiationController::class, 'update_video']);
  Route::post('/activityinitiate/save/video', [\App\Http\Controllers\activityInitiationController::class, 'save_video']);
  Route::post('/activity/edit/bulk', [\App\Http\Controllers\activityInitiationController::class, 'bulk_update']);
  Route::post('/activity/send/required', [\App\Http\Controllers\activityInitiationController::class, 'send_required']);
  Route::post('/activityinitiate/observationrecord', [\App\Http\Controllers\activityInitiationController::class, 'observationrecord']);
  Route::post('/activityinitiate/activeStatus', [\App\Http\Controllers\activityInitiationController::class, 'activeStatus']);
  Route::get('/calendar/event/getdata', [\App\Http\Controllers\ovm1Controller::class, 'GetEventData']);
  Route::post('/activity_initiate/update_toggle', [\App\Http\Controllers\activityInitiationController::class, 'update_toggle']);
  Route::post('activity/f2f/store', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fstore']);
  Route::get('activity/f2f/edit/{id}', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fedit']);
  Route::post('activity/f2f/update', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fupdate']);
  Route::get('activity/f2f/delete', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fdelete']);
  Route::get('/activity/f2f/fetch', [\App\Http\Controllers\activityInitiationController::class, 'fetch'])->name('activity.f2ffetch');

  //master assessmentreport
  Route::get('/master/assessment', [\App\Http\Controllers\MasterAssessmentreportController::class, 'index']);
  Route::get('/master/assessment/create', [\App\Http\Controllers\MasterAssessmentreportController::class, 'createdata']);
  Route::post('/master/assessment/header', [\App\Http\Controllers\MasterAssessmentreportController::class, 'master_header']);
  Route::post('/master/assessment/header/update', [\App\Http\Controllers\MasterAssessmentreportController::class, 'master_header_update']);
  Route::post('/master/assessment/store', [\App\Http\Controllers\MasterAssessmentreportController::class, 'store_data']);
  Route::get('/master/assessment/edit/{id}', [\App\Http\Controllers\MasterAssessmentreportController::class, 'data_edit']);
  Route::post('/master/assessment/update', [\App\Http\Controllers\MasterAssessmentreportController::class, 'update_data']);
  Route::post('/master/final/submit', [\App\Http\Controllers\MasterAssessmentreportController::class, 'final_submit']);
  Route::post('/reports_master/update_toggle', [\App\Http\Controllers\MasterAssessmentreportController::class, 'update_toggle']);
  Route::post('/areaname/master/ajax', [\App\Http\Controllers\assessmentreportController::class, 'area_ajax']);
  // Route::post('/report/recommendation/sail_recommendation', [\App\Http\Controllers\assessmentreportController::class, 'sail_report_recommendation']);
  Route::post('/master/assessment/report_store', [\App\Http\Controllers\MasterAssessmentreportController::class, 'report_store_data']);
  //Email Preview
  Route::post('/emailpreview/storedata', [\App\Http\Controllers\EmailPreviewController::class, 'storedata']);
  Route::get('/emailpreview/getdata', [\App\Http\Controllers\EmailPreviewController::class, 'getdata']);
  Route::get('/emailpreview/create', [\App\Http\Controllers\EmailPreviewController::class, 'create']);
  Route::get('/emailpreview/data_delete/{id}', [\App\Http\Controllers\EmailPreviewController::class, 'data_delete']);
  Route::get('/emailpreview/data_edit/{id}', [\App\Http\Controllers\EmailPreviewController::class, 'data_edit']);
  Route::post('/emailpreview/update_data', [\App\Http\Controllers\EmailPreviewController::class, 'update_data']);



  //sail assessment report
  Route::get('/report/assessmentreport', [\App\Http\Controllers\assessmentreportController::class, 'index']);
  Route::get('/sail/report/list', [\App\Http\Controllers\assessmentreportController::class, 'report_list']);
  Route::get('/report/assessmentreport/create', [\App\Http\Controllers\assessmentreportController::class, 'createdata']);
  Route::post('/report/assessment/new/store', [\App\Http\Controllers\assessmentreportController::class, 'store_data']);
  Route::get('/report/assessmentreport/edit/{id}', [\App\Http\Controllers\assessmentreportController::class, 'data_edit']);
  Route::post('/report/assessment/new/update', [\App\Http\Controllers\assessmentreportController::class, 'update_data']);
  Route::post('/report/sail/sail_assessment', [\App\Http\Controllers\assessmentreportController::class, 'sail_recommendation_download']);
  Route::get('/report/recommendationreport', [\App\Http\Controllers\assessmentreportController::class, 'index_data']);
  Route::get('/report/recommendation/create', [\App\Http\Controllers\assessmentreportController::class, 'create_data']);
  Route::post('/report/recommendation/sail_recommendation', [\App\Http\Controllers\assessmentreportController::class, 'sail_report_download']);
  Route::get('/report/recommendation/edit/{id}', [\App\Http\Controllers\assessmentreportController::class, 'recommendation_data_edit']);
  Route::post('/report/recommendation/new/update', [\App\Http\Controllers\assessmentreportController::class, 'report_update_data']);
  Route::post('/assessment/report/republish', [\App\Http\Controllers\assessmentreportController::class, 'reportRepublish']);
  Route::get('/assessment/report/get/comments', [\App\Http\Controllers\assessmentreportController::class, 'getComment']);
  //sail recommendation report
  Route::get('/areas/master/index', [\App\Http\Controllers\AreasMasterController::class, 'index']);
  Route::post('/area/master/recommendation/store', [\App\Http\Controllers\AreasMasterController::class, 'storedata']);
  Route::get('/areas/master/data_edit/{id}', [\App\Http\Controllers\AreasMasterController::class, 'data_edit']);
  Route::post('/areas/master/update_data', [\App\Http\Controllers\AreasMasterController::class, 'updatedata']);
  Route::get('/area/master/delete/{id}', [\App\Http\Controllers\AreasMasterController::class, 'delete']);
  Route::post('/report/recommendation/new/store', [\App\Http\Controllers\assessmentreportController::class, 'Recommendation_store_data']);

  // In Person Meeting
  Route::get('/inperson/meeting/index', [\App\Http\Controllers\InPersonMeetingController::class, 'index']);
  Route::get('/inperson/meeting/invite', [\App\Http\Controllers\InPersonMeetingController::class, 'create']);
  Route::post('/inperson/meeting/store', [\App\Http\Controllers\InPersonMeetingController::class, 'store']);
  Route::post('/get/sail/details', [\App\Http\Controllers\InPersonMeetingController::class, 'GetSailDetails']);
  Route::get('/inperson/meeting/data_edit/{id}', [\App\Http\Controllers\InPersonMeetingController::class, 'data_edit']);
  Route::post('inperson/meeting/updatedata', [\App\Http\Controllers\InPersonMeetingController::class, 'updatedata']);

  // Referal Report
  Route::get('report/referral/report/index', [\App\Http\Controllers\ReferralReportController::class, 'index']);
  Route::get('/report/referral/report/create', [\App\Http\Controllers\ReferralReportController::class, 'createdata']);
  Route::get('/therapist/specialization/getuser', [\App\Http\Controllers\ReferralReportController::class, 'GetUser']);
  Route::get('/report/referral/report/data_edit/{id}', [\App\Http\Controllers\ReferralReportController::class, 'data_edit']);
  Route::post('/report/referral/report/updatedata', [\App\Http\Controllers\ReferralReportController::class, 'updatedata']);
  Route::post('/report/referral/report/storedata', [\App\Http\Controllers\ReferralReportController::class, 'storedata']);
  Route::post('/report/referral/report/send', [\App\Http\Controllers\ReferralReportController::class, 'send_report']);

  // SAIL Report Republish
  Route::get('/report/republish/get_data/{id}', [\App\Http\Controllers\SailReportRepublish::class, 'GetData']);

  // Calendar
  Route::post('/calendar/availability/store_data', [\App\Http\Controllers\CalendarController::class, 'storedata']);

  //Quadrant Questionnaire
  Route::get('/quadrant/questionnaire/index', [\App\Http\Controllers\QuadrantQuestionnaireController::class, 'index']);
  Route::get('/quadrant/questionnaire/create', [\App\Http\Controllers\QuadrantQuestionnaireController::class, 'create']);
  Route::post('/quadrant/questionnaire/store', [\App\Http\Controllers\QuadrantQuestionnaireController::class, 'store']);

  // 
  Route::get('ovm_allocation/index', [\App\Http\Controllers\OVMAllocationController::class, 'index']);
  Route::get('/ovmallocation/meetinginvite', [\App\Http\Controllers\OVMAllocationController::class, 'meetinginvite']);
  Route::post('ovm_allocation/store', [\App\Http\Controllers\OVMAllocationController::class, 'store']);
  Route::get('/ovm_allocation/data_edit/{id}', [\App\Http\Controllers\OVMAllocationController::class, 'data_edit']);
  Route::get('/ovm_allocation/getdetail/{id}', [\App\Http\Controllers\OVMAllocationController::class, 'getdetails']);
  Route::post('ovm_allocation/update_data', [\App\Http\Controllers\OVMAllocationController::class, 'update_data']);
  Route::post('ovm_allocation/user_update', [\App\Http\Controllers\OVMAllocationController::class, 'user_update']);

  //IS-Coordinator
  Route::get('coordinator_allocation/index', [\App\Http\Controllers\CoordinatorAllocationController::class, 'index']);
  Route::post('/coordinator/allocation/store', [App\Http\Controllers\CoordinatorAllocationController::class, 'allocate_store'])->name('coordinator.allocate_store');
  Route::get('/coordinator/list/view', [App\Http\Controllers\CoordinatorAllocationController::class, 'list'])->name('coordinator.list');
  Route::get('/coordinator/allocation/show/{id}', [\App\Http\Controllers\CoordinatorAllocationController::class, 'show']);
  Route::get('/coordinator/allocation/edit/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'edit'])->name('coordinator.edit');
  Route::post('/coordinator/reallocation/update', [App\Http\Controllers\CoordinatorAllocationController::class, 'reallocation'])->name('coordinator.reallocation');
  Route::get('/coordinator/cancellation/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'cancellation'])->name('coordinator.cancellation');
  Route::post('/coordinator/cancellation/store', [App\Http\Controllers\CoordinatorAllocationController::class, 'cancellation_store'])->name('coordinator.cancellation_store');
  Route::get('/allocation/list/view', [App\Http\Controllers\CoordinatorAllocationController::class, 'child_list'])->name('coordinator.child_list');


  //OVM ALLOCATION
  Route::get('/ovm_allocation/meetinginvite', [\App\Http\Controllers\CoordinatorAllocationController::class, 'meetinginvite']);
  Route::post('ovm/allocation/store', [\App\Http\Controllers\CoordinatorAllocationController::class, 'ovm_store']);


  //date validation
  Route::get('/meeting/date/validation', [App\Http\Controllers\CoordinatorAllocationController::class, 'date_validation'])->name('coordinator_allocation.date_validation');

  //OVM calendar 
  Route::get('/ovmmeetingview', [\App\Http\Controllers\CoordinatorAllocationController::class, 'calendar_list']);

  // //COMPASS
  // Route::resource('compass', CompassController::class);
  // Route::get('/compassstatus', [App\Http\Controllers\CompassController::class, 'index'])->name('compassstatus');
  // Route::get('/compass/initiate/new', [App\Http\Controllers\CompassController::class, 'CompassInitiate'])->name('compassstatus.initiate');
  // Route::post('/compassstatus/store', [App\Http\Controllers\CompassController::class, 'store'])->name('compass_store');
  // //COMPASS PAYMENT   
  // Route::get('/register/compass/compasscreate', [\App\Http\Controllers\UserregisterfeeController::class, 'compass_create_data'])->name('compass_register_fee');
  // Route::post('/compassregisterfee/store_data', [App\Http\Controllers\UserregisterfeeController::class, 'compass_store_data'])->name('compass_store_data');
  // Route::get('/compassregisterfee/show_data/{id}', [App\Http\Controllers\UserregisterfeeController::class, 'compass_show'])->name('compass_show');
  // //Therapist Allocation
  // Route::resource('therapistallocation', TherapistAllocationController::class);
  // Route::get('/therapist', [App\Http\Controllers\TherapistAllocationController::class, 'index'])->name('therapist.index');
  // Route::get('/therapist/initation', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistInit'])->name('TherapistInit');
  // Route::post('/therapist/specialization', [App\Http\Controllers\TherapistAllocationController::class, 'Therapistspecialization'])->name('Therapistspecialization');
  // Route::get('/externaltherapist', [App\Http\Controllers\TherapistAllocationController::class, 'ExternalAllocation'])->name('ExternalAllocation');
  // //Compass meeting
  // Route::resource('compassmeeting', CompassMeetingController::class);
  // Route::get('/compassmeeting', [App\Http\Controllers\CompassMeetingController::class, 'index'])->name('compassmeeting');
  // Route::get('/CompassNewmeetinginvite', [App\Http\Controllers\CompassMeetingController::class, 'CompassNewmeetinginvite'])->name('CompassNewmeetinginvite');
  // Route::post('/compassmeeting/store', [\App\Http\Controllers\CompassMeetingController::class, 'store'])->name('compass.meeting.store');
  // Route::get('/compassmeeting/show/{id}', [App\Http\Controllers\CompassMeetingController::class, 'show'])->name('compass.meeting.show');
  // Route::get('/compassmeeting/edit/{id}', [App\Http\Controllers\CompassMeetingController::class, 'edit'])->name('compass.meeting.edit');
  // Route::post('/compassmeeting/update/{id}', [\App\Http\Controllers\CompassMeetingController::class, 'update'])->name('compass.meeting.update');
  // //Home Tracker
  // Route::resource('hometracker', HomeTrackerController::class);
  // Route::get('/hometracker', [App\Http\Controllers\HomeTrackerController::class, 'index'])->name('hometracker');
  // Route::post('/hometracker/store', [\App\Http\Controllers\HomeTrackerController::class, 'store'])->name('home.tracker.store');
  // Route::get('/hometracker/parentinitiate/new/{id}', [App\Http\Controllers\HomeTrackerController::class, 'viewform'])->name('hometracker.viewform');
  // Route::post('/hometracker/viewcal', [App\Http\Controllers\HomeTrackerController::class, 'viewcalendar'])->name('viewcale');
  // Route::get('/hometrackerInit', [App\Http\Controllers\HomeTrackerController::class, 'hometrackerInit'])->name('hometrackerInit');
  // //Question creation for compass
  // Route::resource('compassquestion_creation', CompassQuestionCreationController::class);
  // Route::get('/compassquestion_creation', [App\Http\Controllers\CompassQuestionCreationController::class, 'index'])->name('compassquestion_creation');
  // Route::get('/compassquestion_creation/create', [App\Http\Controllers\CompassQuestionCreationController::class, 'create'])->name('compassquestion_creation.create');
  // //Payuserfree
  // Route::get('/compasspay_create', [\App\Http\Controllers\Paymentcontroller::class, 'compasspay_create'])->name('compasspay_create');
  // Route::get('/compasspay_create/show_data/{id}', [App\Http\Controllers\Paymentcontroller::class, 'compasspay_show'])->name('compasspay_show');

  //cashfree payment
  Route::get('/cashpayment/refund', [\App\Http\Controllers\Paymentcontroller::class, 'refund_index'])->name('refund_index');
  // PerformanceAreaController
  Route::get('/performancearea/get_data', [\App\Http\Controllers\PerformanceAreaController::class, 'index']);
  Route::get('/performancearea/create_data', [\App\Http\Controllers\PerformanceAreaController::class, 'create_data']);
  Route::post('/performancearea/update_data', [\App\Http\Controllers\PerformanceAreaController::class, 'update_data']);
  Route::post('/performancearea/storedata', [\App\Http\Controllers\PerformanceAreaController::class, 'store_data']);

  // Conversation Summery Master
  Route::get('/conversation/summery/getdata/{id}', [\App\Http\Controllers\ConversationMasterController::class, 'getdata']);
  Route::post('/conversation/summery/storedata', [\App\Http\Controllers\ConversationMasterController::class, 'store_data']);
  Route::post('/conversation/summery/updatedata', [\App\Http\Controllers\ConversationMasterController::class, 'update_data']);


  //Activity Initiatation of 13+
  Route::post('/parentvideo13/description', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'Getdescription']);

  //Auto Save
  Route::post('/autosave/store', [App\Http\Controllers\ovm1Controller::class, 'autosave'])->name('autosave');

  //assessment_activity
  Route::post('/report/assessmentreport/observation', [App\Http\Controllers\assessmentreportController::class, 'observation_view'])->name('assessmentreport.observation_view');

  //meeting_des
  Route::post('/report/meeting_description_ass/update', [App\Http\Controllers\assessmentreportController::class, 'meetingdes_updation'])->name('assessmentreport.meetingdes_updation');

  //Questionnaire updation
  Route::post('/questionnaire/updateoption', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'upload_update']);
  Route::post('/questionnaire/updateoption/parent', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'upload_update_parent']);


  // /business/affiliate/store_data
  Route::get('/business/affiliate/index', [\App\Http\Controllers\BusinessCategoryMasterAPIController::class, 'index']);
  Route::get('/business/affiliate/create', [\App\Http\Controllers\BusinessCategoryMasterAPIController::class, 'create']);
  Route::post('/business/affiliate/storedata', [\App\Http\Controllers\BusinessCategoryMasterAPIController::class, 'storedata']);
  Route::get('/business/affiliate/getdata', [\App\Http\Controllers\BusinessCategoryMasterAPIController::class, 'getdata']);
  Route::post('/business/affiliate/updatedata', [\App\Http\Controllers\BusinessCategoryMasterAPIController::class, 'updatedata']);

  Route::get('/payment/customized/sail/index', [\App\Http\Controllers\CustomizedPaymentAPIController::class, 'index']);
  Route::get('/payment/customized/sail/create', [\App\Http\Controllers\CustomizedPaymentAPIController::class, 'create']);
  Route::post('/payment/customized/sail/storedata', [\App\Http\Controllers\CustomizedPaymentAPIController::class, 'storedata']);
  Route::get('/payment/customized/sail/getdata', [\App\Http\Controllers\CustomizedPaymentAPIController::class, 'getdata']);
  Route::post('/payment/customized/sail/updatedata', [\App\Http\Controllers\CustomizedPaymentAPIController::class, 'updatedata']);


  Route::get('/service/briefing/master', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'ServiceBriefing']);
  Route::get('/service/briefing/master/index', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'index']);
  Route::get('/service/briefing/master/create', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'create']);
  Route::post('/service/briefing/master/store', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'store_data']);
  Route::get('/service/briefing/master/getdata/{id}', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'getdata']);
  Route::post('/service/briefing/master/update', [App\Http\Controllers\ServiceBriefingMasterAPIController::class, 'update']);
});

Route::fallback(function () {
  return redirect()->route('not.found');
});

Route::get('unauthenticated', [\App\Http\Controllers\AuthController::class, 'Unauthenticated'])->name('unauthenticated');

Route::get('user/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/user/unauthenticated/{id}', [\App\Http\Controllers\AuthController::class, 'user_unauthenticate']);
Route::POST('/user/require_captcha', [\App\Http\Controllers\AuthController::class, 'require_captcha']);
Route::get('not/found', [\App\Http\Controllers\AuthController::class, 'NotFound'])->name('not.found');
Route::get('/server/test', [\App\Http\Controllers\AuthController::class, 'ServerTest']);
Route::get('/ovm1/resend', [\App\Http\Controllers\ovm1Controller::class, 'resend']);

//Payment Master
Route::get('/payment_master/index', [\App\Http\Controllers\MasterPaymentController::class, 'index']);
Route::get('/payment_master/data_delete/{id}', [\App\Http\Controllers\MasterPaymentController::class, 'data_delete']);
Route::get('/payment_master/data_edit/{id}', [\App\Http\Controllers\MasterPaymentController::class, 'data_edit']);
Route::post('/payment_master/updatedata', [\App\Http\Controllers\MasterPaymentController::class, 'updatedata']);
Route::get('/payment_master/create', [\App\Http\Controllers\MasterPaymentController::class, 'create']);
Route::post('/payment_master/storedata', [\App\Http\Controllers\MasterPaymentController::class, 'storedata']);
Route::get('/payment_master/show', [\App\Http\Controllers\MasterPaymentController::class, 'show']);
Route::post('/payment/master/toggle_data', [\App\Http\Controllers\MasterPaymentController::class, 'toggle']);
Route::post('/payment/master/hold_data', [\App\Http\Controllers\MasterPaymentController::class, 'hold']);
Route::post('/payment/master/cancel', [\App\Http\Controllers\MasterPaymentController::class, 'cancel']);

// Sarany (React-testimonials)
Route::get('/testimonial/{id}', [App\Http\Controllers\WebpageController::class, 'testimonial'])->name('testimonial');
Route::get('/dailyquotes', [App\Http\Controllers\WebpageController::class, 'dailyquotes'])->name('dailyquotes');
Route::post('/newsletters/storedata', [App\Http\Controllers\WebpageController::class, 'storedata']);
Route::post('/newinquires/storedata', [App\Http\Controllers\WebpageController::class, 'newinquires']);
Route::get('/blog_comment', [App\Http\Controllers\WebpageController::class, 'blog_comment'])->name('blog_comment');
