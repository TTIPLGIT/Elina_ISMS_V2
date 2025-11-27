
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UamModulesController;
use App\Http\Controllers\UamScreensController;
use App\Http\Controllers\UamModulesScreensController;
use App\Http\Controllers\FAQmodulesController;
use App\Http\Controllers\FAQquestionsController;
use App\Http\Controllers\UamDataController;
use App\Http\Controllers\questionmastercontroller;
use App\Http\Controllers\UamRolesController;
use App\Http\Controllers\UamUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewenrollementController;
use App\Http\Controllers\UserregisterfeeController;
use App\Http\Controllers\Paymentcontroller;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\ovm1Controller;
use App\Http\Controllers\InPersonMeetingController;
use App\Http\Controllers\ElinademoforparentsController;
use App\Http\Controllers\SaildocumentController;
use App\Http\Controllers\ovm2Controller;
use App\Http\Controllers\serviceprovidercontroller;
use App\Http\Controllers\internshipcontroller;
use App\Http\Controllers\activityInitiationController;
use App\Http\Controllers\CompassController;
use App\Http\Controllers\TherapistAllocationViewController;
use App\Http\Controllers\HomeTrackerController;
use App\Http\Controllers\RecommendationMasterController;
use App\Http\Controllers\QuestionCreationController;
use App\Http\Controllers\ParentsQuestionnaireController;
use App\Http\Controllers\QuestionnaireMasterCreation;
use App\Http\Controllers\ParentvideouploadController;
use App\Http\Controllers\MasterAssessmentreportController;
use App\Http\Controllers\assessmentreportController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\PerformanceAreaController;
use App\Http\Controllers\SWOTMasterController;
use App\Http\Controllers\AreasMasterController;
use App\Http\Controllers\ReferralReportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\QuadrantQuestionnaireController;
use App\Http\Controllers\AssessmentMapping;
use App\Http\Controllers\OVMAllocationController;
use App\Http\Controllers\SailReportRepublish;
use App\Http\Controllers\cashfreecontroller;
use App\Http\Controllers\CoordinatorAllocationController;
use App\Http\Controllers\ConversationMasterController;
use App\Http\Controllers\ChildWebsiteController;
use App\Http\Controllers\MonthlyObjectiveController;
use App\Http\Controllers\WeeklyFeedbackController;
use App\Http\Controllers\MasterObservationController;
use App\Http\Controllers\TherapistAllocationController;
use App\Http\Controllers\CompassMeetingController;
use App\Http\Controllers\CompassObservationController;
use App\Http\Controllers\AboveagemanagementController;
use App\Http\Controllers\MasterQuestionCreationController;
use App\Http\Controllers\MasterQuestionnaireCreationController;
use App\Http\Controllers\thirteenyrsquestionnaireallocation;
use App\Http\Controllers\QuestionnaireCreationController;
use App\Http\Controllers\ChildQuestionnaireController;
use App\Http\Controllers\thirteenyrsactivityallocation;
use App\Http\Controllers\ReportFileController;
use App\Http\Controllers\MasterPaymentController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
})->name('/');
Route::get('/isms', function () {
    return view('auth.login');
});
Route::get('/tinymce', function () {
    return redirect()->away('https://elinaservices.com:60162/api/settings/tinymce');
});
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index1']);
Route::get('interns', [App\Http\Controllers\LoginController::class, 'intern'])->name('intern');
Route::get('serviceproviders', [App\Http\Controllers\LoginController::class, 'serviceprovider'])->name('serviceprovider');
Route::post('loginotp', [App\Http\Controllers\LoginController::class, 'loginotp'])->name('loginotp');
Route::post('/que_search', [\App\Http\Controllers\FAQController::class, 'que_search'])->name('que_search');
Route::post('/ans_search', [\App\Http\Controllers\FAQController::class, 'ans_search'])->name('ans_search');
Route::get('/privacypage', [\App\Http\Controllers\LoginController::class, 'privacypage'])->name('privacypage');
Route::get('register', [App\Http\Controllers\LoginController::class, 'register'])->name('register');
Route::get('/FAQ', [\App\Http\Controllers\FAQController::class, 'index'])->name('FAQ');
Route::get('/forgot', [\App\Http\Controllers\LoginController::class, 'forgot'])->name('forgot');
Route::post('/forgot_password', [\App\Http\Controllers\LoginController::class, 'forgot_password'])->name('forgot_password');
Route::get('/reset/{id}', [\App\Http\Controllers\LoginController::class, 'reset'])->name('reset');
Route::post('/reset_password', [\App\Http\Controllers\LoginController::class, 'reset_password'])->name('reset_password');
Route::get('otp', [App\Http\Controllers\LoginController::class, 'otp'])->name('otp');
Route::post('registerstore', [App\Http\Controllers\LoginController::class, 'registerstore'])->name('registerstore');
Route::post('otpstore', [App\Http\Controllers\LoginController::class, 'otpstore'])->name('otpstore');
Route::post('onetimepassword', [App\Http\Controllers\LoginController::class, 'onetimepassword'])->name('onetimepassword');
Route::post('VerifyOTP', [App\Http\Controllers\LoginController::class, 'VerifyOTP'])->name('VerifyOTP');
Route::get('/tokenexpire', [\App\Http\Controllers\AlertController::class, 'tokenexpire'])->name('tokenexpire');
Route::get('/dompdf', [\App\Http\Controllers\LoginController::class, 'dompdf']);
Route::get('/mpdf', [\App\Http\Controllers\LoginController::class, 'mpdf']);
Route::get('/gcap', [\App\Http\Controllers\LoginController::class, 'gcap']);
Route::get('/googledoc', [\App\Http\Controllers\LoginController::class, 'googledoc']);
Route::get('/submitDenial/{id}', [SaildocumentController::class, 'submitDenial'])->name('submitDenial');
Route::resource('Registration', RegistrationController::class);
Route::get('educreate', [RegistrationController::class, 'educreate'])->name('educreate');
Route::get('eduedit/{id}', [RegistrationController::class, 'eduedit'])->name('eduedit');
Route::get('expedit/{id}', [RegistrationController::class, 'expedit'])->name('expedit');
Route::get('edushow/{id}', [RegistrationController::class, 'edushow'])->name('edushow');
Route::get('expshow/{id}', [RegistrationController::class, 'expshow'])->name('expshow');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/user/session/expire', [\App\Http\Controllers\LoginController::class, 'sessionexpire'])->name('sessionexpire');
Route::resource('tokenmaster', questionmastercontroller::class);
Route::resource('/uam_modules', UamModulesController::class);
Route::post('view_proposal_documents', [NewenrollementController::class, 'view_proposal_documents'])->name('view_proposal_documents');
Route::post('view_attachment_documents', [ovm2Controller::class, 'view_proposal_documents'])->name('view_attachment_documents');
Route::put('destroygen', [RegistrationController::class, 'destroygen'])->name('destroygen');
Route::put('destroyexp', [RegistrationController::class, 'destroyexp'])->name('destroyexp');
Route::put('destroyedu', [RegistrationController::class, 'destroyedu'])->name('destroyedu');
Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/enrollnow', [App\Http\Controllers\EnrollementController::class, 'create'])->name('enrollnow');
Route::post('/enrollement/store', [App\Http\Controllers\EnrollementController::class, 'store'])->name('enrollement.store');
Route::get('/questionnaire/dashboard', [App\Http\Controllers\ParentsQuestionnaireController::class, 'dashboard'])->name('questionnaire.dashboard');
Route::get('sail/signed/initiate/{id?}/{a?}', [SaildocumentController::class, 'signedLoginSub'])->name('signed.sail.initiate');
Route::get('/schoolenroll', [App\Http\Controllers\SchoolenrollmentController::class, 'create'])->name('schoolenroll');
Route::post('/schoolenrollement/store', [App\Http\Controllers\SchoolenrollmentController::class, 'store'])->name('schoolenrollement.store');
Route::get('/unauthenticated', [\App\Http\Controllers\AlertController::class, 'unauthenticated'])->name('unauthenticated');
Route::get('/multipledevice', [\App\Http\Controllers\AlertController::class, 'multipledevice'])->name('multipledevice');
Route::get('/internal_redirect', [\App\Http\Controllers\AlertController::class, 'internal_redirect'])->name('internal_redirect');

Route::resource('internship', internshipcontroller::class);
Route::resource('serviceprovider', serviceprovidercontroller::class);
Route::get('payuserfees/{id}', [Paymentcontroller::class, 'create1'])->name('payuserfees.create1')->middleware('signed');
Route::get('/ovm/allocation/signed/{id}', [OVMAllocationController::class, 'SignedLogin'])->name('ovm.allocation.signed')->middleware('signed');
Route::get('/g2form/signed/{id}', [OVM1Controller::class, 'SignedLogin'])->name('g2form.signed')->middleware('signed');
Route::get('questionnaire/signed/form/{id?}/{a?}', [SaildocumentController::class, 'SignedQuestionnaire'])->name('signed.questionnaire')->middleware('signed');
Route::get('/referral/request/{id}', [SaildocumentController::class, 'referral_request'])->name('referral_request');
Route::post('/validate/enrollment/user', [\App\Http\Controllers\EnrollementController::class, 'ValidateEnrollment'])->name('enrollment.validate');

Route::match(['get', 'post'], '/my-route', [App\Http\Controllers\LoginController::class, 'myMethod'])->name('original.route.name');
Route::get('/user/session/check', [App\Http\Controllers\LoginController::class, 'checkSession'])->name('user.session');
Route::group(['middleware' => 'usersession'], function () {

    Route::post('elinaleadsearch', [App\Http\Controllers\HomeController::class, 'elinaleadsearch'])->name('elinaleadsearch');
    Route::resource('uam_screens', UamScreensController::class);
    Route::post('getscreenpermission', [UamScreensController::class, 'getscreenpermission'])->name('getscreenpermission');
    Route::resource('uam_modules_screens', UamModulesScreensController::class);
    Route::post('uam_modules_screens/screen_data_get', [UamModulesScreensController::class, 'screen_data_get'])->name('screen_data_get');
    Route::post('/uam_modules_screens/get_modules_screen', [UamModulesScreensController::class, 'get_modules_screen']);
    Route::post('/uam_modules_screens/get_sub_module', [\App\Http\Controllers\UamModulesScreensController::class, 'get_sub_module'])->name('get_sub_module');
    Route::resource('uam_roles', UamRolesController::class);
    Route::resource('user', UserController::class);
    Route::get('list_index', [UamUserController::class, 'list_index'])->name('list_index');
    Route::post('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::post('update_user_data', [App\Http\Controllers\UserController::class, 'update_user_data'])->name('update_user_data');
    Route::get('/reset_token_expire_method', [\App\Http\Controllers\UserController::class, 'reset_token_expire_method'])->name('user.reset_token_expire_method');
    Route::post('/user/token_expire_data_update', [\App\Http\Controllers\UserController::class, 'token_expire_data_update'])->name('user.token_expire_data_update');
    Route::get('/project_roles_list', [\App\Http\Controllers\UserController::class, 'project_roles_list'])->name('user.project_roles_list');
    Route::get('/bulk_upload', [\App\Http\Controllers\UserController::class, 'bulk_upload'])->name('user.bulk_upload');
    Route::post('/user/update_toggle', [\App\Http\Controllers\UserController::class, 'update_toggle'])->name('user.update_toggle');
    Route::get('/user/edit_permission/{id}', [\App\Http\Controllers\UserController::class, 'edit_permission'])->name('user.edit_permission');
    Route::post('/user/update_data_permission', [\App\Http\Controllers\UserController::class, 'update_data_permission'])->name('user.update_data_permission');
    Route::resource('/uam_data', UamDataController::class);
    Route::get('/change_password_admin/{id}', [\App\Http\Controllers\UserController::class, 'change_password_admin'])->name('user.change_password_admin');
    Route::post('/designation/bulkdummyupload', [\App\Http\Controllers\DesignationController::class, 'bulkdummyupload'])->name('designation.bulkdummyupload');
    Route::post('/designation/checking_data', [\App\Http\Controllers\DesignationController::class, 'checking_data'])->name('designation.checking_data');
    Route::post('/designation/bulkdemodummyupload', [\App\Http\Controllers\DesignationController::class, 'bulkdemodummyupload'])->name('designation.bulkdemodummyupload');
    Route::get('/not-authorized', [\App\Http\Controllers\AlertController::class, 'not_allow'])->name('not_allow');
    Route::post('/uam_modules_screens/update_data', [\App\Http\Controllers\UamModulesScreensController::class, 'update_data'])->name('uam_modules_screens.update_data');
    Route::get('/elearningDashboard', [App\Http\Controllers\elearningController::class, 'dashboard'])->name('elearningDashboard');
    Route::get('/elearningAllCourses', [App\Http\Controllers\elearningController::class, 'allCourses'])->name('elearningAllCourses');
    Route::get('/elearningWishlist', [App\Http\Controllers\elearningController::class, 'wishlist'])->name('elearningWishlist');
    Route::resource('newenrollment', NewenrollementController::class);
    Route::get('internlist', [NewenrollementController::class, 'internlist'])->name('internlist');
    Route::get('servicelist', [NewenrollementController::class, 'servicelist'])->name('servicelist');
    Route::get('internview/{id}', [NewenrollementController::class, 'internview'])->name('internview');
    Route::get('serviceproviderview/{id}', [NewenrollementController::class, 'serviceproviderview'])->name('serviceproviderview');
    Route::get('/user/create/delete/{id}', [\App\Http\Controllers\NewenrollementController::class, 'delete'])->name('newenrollment.delete');
    Route::resource('userregisterfee', UserregisterfeeController::class);
    Route::get('/userregisterfee/delete/{id}', [\App\Http\Controllers\UserregisterfeeController::class, 'delete'])->name('userregisterfee.delete');
    Route::get('/offline/payment/{id}', [\App\Http\Controllers\UserregisterfeeController::class, 'offline_payment'])->name('userregisterfee.offline_payment');
    Route::post('/offline/complete/payment', [\App\Http\Controllers\UserregisterfeeController::class, 'completepayment'])->name('userregisterfee.completepayment');
    Route::resource('payuserfee', Paymentcontroller::class);
    Route::get('/show/payment/details/{id}', [App\Http\Controllers\Paymentcontroller::class, 'payment_details'])->name('payment.payment_details');
    Route::post('/payment/offline/request', [App\Http\Controllers\Paymentcontroller::class, 'offline_request'])->name('payment.offline.request');
    Route::get('/payuserfee/create_data/{id}', [\App\Http\Controllers\Paymentcontroller::class, 'create_data'])->name('payuserfee.create_data');
    Route::get('/compasspay_create', [\App\Http\Controllers\Paymentcontroller::class, 'compasspay_create'])->name('compasspay_create');
    Route::get('/compasspay_create/show_data/{id}', [App\Http\Controllers\Paymentcontroller::class, 'compasspay_show'])->name('compasspay_show');
    Route::get('razorpay-payment', [RazorpayPaymentController::class, 'index']);
    Route::post('razorpay-payments', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
    Route::resource('ovm1', ovm1Controller::class);

    Route::get('/g2form/{id}', [\App\Http\Controllers\ovm1Controller::class, 'g2form_new'])->name('g2form.new');
    Route::get('/g2form/list/view', [\App\Http\Controllers\ovm1Controller::class, 'g2form_list'])->name('g2form.list');
    Route::post('/g2form/store', [App\Http\Controllers\ovm1Controller::class, 'g2form_storedata'])->name('g2form.store');

    Route::get('/ovm1/delete/{id}', [\App\Http\Controllers\ovm1Controller::class, 'delete'])->name('ovm1.delete');
    Route::get('ovmsent/{id}', [App\Http\Controllers\ovm1Controller::class, 'ovmsent'])->name('ovmsent');
    Route::get('ovmcompleted/{id?}/{a?}', [App\Http\Controllers\ovm1Controller::class, 'ovmcompleted'])->name('ovmcompleted');
    Route::get('ovmcompletedisedit/{id?}/{a?}', [App\Http\Controllers\ovm1Controller::class, 'ovmcompletedisedit'])->name('ovmcompletedisedit');
    Route::get('ovm_completedisedit/{id?}/{meet?}/{a?}', [App\Http\Controllers\ovm1Controller::class, 'ovmcompleted_isedit'])->name('ovmcompleted_isedit');
    Route::put('ovmiscfeedbackstore/{id}', [App\Http\Controllers\ovm1Controller::class, 'ovmiscfeedbackstore'])->name('ovmiscfeedbackstore');
    Route::put('ovmiscfeedback_update/{id}', [App\Http\Controllers\ovm1Controller::class, 'ovmiscfeedback_update'])->name('ovmiscfeedback_update');

    Route::get('feedbacksubmit/{id}', [App\Http\Controllers\ovm1Controller::class, 'feedbacksubmit'])->name('feedbacksubmit');
    Route::get('ovmmeetingcompleted', [App\Http\Controllers\ovm1Controller::class, 'ovmmeetingcompleted'])->name('ovmmeetingcompleted');
    Route::get('ovmreport', [App\Http\Controllers\ovm1Controller::class, 'ovmreport'])->name('ovmreport');
    Route::get('ovmreportview/{id}', [App\Http\Controllers\ovm1Controller::class, 'ovmreportview'])->name('ovmreportview');
    Route::get('/Newmeetinginvite', [App\Http\Controllers\ovm1Controller::class, 'Newmeetinginvite'])->name('Newmeetinginvite');
    Route::get('/ovm/questionnaireinitiate', [App\Http\Controllers\ovm1Controller::class, 'questionnaire'])->name('ovm/questionnaireinitiate');
    Route::get('/ovm/report/preview/{id}', [App\Http\Controllers\ovm1Controller::class, 'preview'])->name('ovm.preview');
    Route::post('/ovm/report/store', [App\Http\Controllers\ovm1Controller::class, 'previewstore'])->name('ovm.preview.store');
    Route::post('/sail/guide/save', [App\Http\Controllers\ovm1Controller::class, 'sailguideSave'])->name('sailguide.save');
    Route::post('report/SailGuide/generatePDF', [App\Http\Controllers\ovm1Controller::class, 'generatePDF'])->name('ovm.generatePDF');
    Route::post('report/SailGuide/generatePDFPreview', [App\Http\Controllers\ovm1Controller::class, 'generatePDFPreview'])->name('ovm.generatePDFPreview');
    Route::resource('ovm2', ovm2Controller::class);
    Route::get('/ovm2/delete/{id}', [\App\Http\Controllers\ovm2Controller::class, 'delete'])->name('ovm2.delete');
    Route::get('ovmsent2/{id}', [App\Http\Controllers\ovm2Controller::class, 'ovmsent2'])->name('ovmsent2');
    Route::get('/Newmeetinginvite2', [App\Http\Controllers\ovm2Controller::class, 'Newmeetinginvite2'])->name('Newmeetinginvite2');
    Route::post('getchilddetails', [App\Http\Controllers\ovm1Controller::class, 'getchilddetails'])->name('getchilddetails');
    Route::resource('elinademo', ElinademoforparentsController::class);
    Route::get('/Elinademo/delete/{id}', [\App\Http\Controllers\ElinademoforparentsController::class, 'delete'])->name('elinademo.delete');
    Route::post('/userregisterfee/enrollmentlist', [\App\Http\Controllers\UserregisterfeeController::class, 'GetAllDepartmentsByDirectorate'])->name('userregisterfee.enrollmentlist');
    Route::post('/sensory/enrollmentlist', [\App\Http\Controllers\UserregisterfeeController::class, 'SensoryGetData'])->name('sensory.enrollmentlist');
    Route::post('/activityinitiate/ajax', [\App\Http\Controllers\activityInitiationController::class, 'activityajax'])->name('activityinitiate.ajax');
    Route::post('/parentvideo/description', [\App\Http\Controllers\ParentvideouploadController::class, 'description'])->name('parentvideo.description');
    Route::post('/parentvideo/materials', [\App\Http\Controllers\ParentvideouploadController::class, 'materials_fetch'])->name('parentvideo.materials');
    Route::post('/parentvideo/f2fdescription', [\App\Http\Controllers\ParentvideouploadController::class, 'f2f_description'])->name('parentvideo.f2f_description');

    Route::post('/activity/edit/bulk', [\App\Http\Controllers\activityInitiationController::class, 'bulk_update'])->name('activity.bulk_update');
    Route::post('/activity/send/required', [\App\Http\Controllers\activityInitiationController::class, 'send_required'])->name('activity.send.required');
    Route::post('/user/notifications', [\App\Http\Controllers\UserController::class, 'notifications'])->name('user.notifications');
    Route::post('/user/notification_alert', [\App\Http\Controllers\UserController::class, 'notification_alert'])->name('user.notification_alert');
    Route::get('/enrollement_schoollist', [App\Http\Controllers\SchoolenrollmentController::class, 'index'])->name('enrollement.schoollist');
    Route::get('/enrollement/schoolshow/{id}', [App\Http\Controllers\SchoolenrollmentController::class, 'show'])->name('enrollement.schoolshow');
    Route::get('/enrollement/schooledit/{id}', [App\Http\Controllers\SchoolenrollmentController::class, 'edit'])->name('enrollement.schooledit');
    Route::post('/enrollement/update/{id}', [App\Http\Controllers\SchoolenrollmentController::class, 'update'])->name('enrollement.update');
    // Route::resource('questionnaire', QuestionnaireCreationController::class);

    //cash free payment

    Route::post('cashfree/payments/store', [cashfreecontroller::class, 'store'])->name('cash_store');
    Route::get('cashfree/payments/success', [cashfreecontroller::class, 'success'])->name('success');

    //SAIL DOCUMENT
    Route::resource('sail', SaildocumentController::class);
    Route::get('/sail/edit/status/{id}', [\App\Http\Controllers\SaildocumentController::class, 'edit_data'])->name('sail.status.edit');
    Route::get('/sailstatus', [App\Http\Controllers\SaildocumentController::class, 'sailstatus'])->name('sailstatus');
    Route::get('/questionnaireinitiate', [App\Http\Controllers\SaildocumentController::class, 'questionnaireinitiate'])->name('questionnaireinitiate');
    Route::get('/sail/data_delete/{id}', [\App\Http\Controllers\SaildocumentController::class, 'delete'])->name('sail.delete');
    Route::get('/ovm/questionnaire/initiate', [App\Http\Controllers\SaildocumentController::class, 'questionnaireinitiate'])->name('ovm.questionnaire.initiate');
    Route::post('/sail/getchild/enrollment', [\App\Http\Controllers\SaildocumentController::class, 'GetAllDepartmentsByDirectorate'])->name('/sail/initiate');
    Route::get('/sail/initiate/new', [App\Http\Controllers\SaildocumentController::class, 'SailInitiate'])->name('sailstatus.initiate');
    Route::post('/sail/initiate/store', [App\Http\Controllers\SaildocumentController::class, 'SailInitiateStore'])->name('sail.initiate.sotre');
    Route::post('/sail/reinitiate/store', [App\Http\Controllers\SaildocumentController::class, 'SailReInitiateStore'])->name('sail.reinitiate.store');
    Route::get('/sailquestionnaireinitiate', [App\Http\Controllers\SaildocumentController::class, 'sailquestionnaireinitiate'])->name('sailquestionnaireinitiate');
    Route::get('/sailquestionnairelistview', [App\Http\Controllers\SaildocumentController::class, 'questionnaireindex'])->name('sailquestionnairelistview');
    Route::post('/sail/sailstoredata', [App\Http\Controllers\SaildocumentController::class, 'sail_store'])->name('sailstore');
    Route::get('/sail/consent/form/{id}', [App\Http\Controllers\SaildocumentController::class, 'sail_consent'])->name('sail.consent');
    Route::post('/sail/consent/form/store', [App\Http\Controllers\SaildocumentController::class, 'SailConsentAccept'])->name('sail.consent.accept');
    Route::post('/sail/process/denail', [App\Http\Controllers\SaildocumentController::class, 'SailConsentDenail'])->name('sail.consent.denial');

    //SAIL PAYMENT   
    Route::get('/register/sail/sailcreate', [\App\Http\Controllers\UserregisterfeeController::class, 'sail_create_data'])->name('sail_register_fee');
    Route::post('/userregisterfee/store_data', [App\Http\Controllers\UserregisterfeeController::class, 'store_data'])->name('userregisterfee/store_data');
    Route::post('/report/download', [App\Http\Controllers\ovm1Controller::class, 'report_download'])->name('report_download');
    Route::post('/report/send', [App\Http\Controllers\ovm1Controller::class, 'send_report'])->name('send_report');
    Route::post('/report/ovm/download', [App\Http\Controllers\ovm1Controller::class, 'ovm_report_download'])->name('report_ovm_download');

    //Question Creation
    Route::resource('question_creation', QuestionCreationController::class);
    Route::post('/question_creation/store_data', [\App\Http\Controllers\QuestionCreationController::class, 'store_data'])->name('question_creation.store_data');
    Route::post('/question_creation/update_data', [\App\Http\Controllers\QuestionCreationController::class, 'update_data'])->name('question_creation.update_data');
    Route::get('/question_creation/delete/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'delete'])->name('question_creation.delete');
    Route::get('/question_creation/add_questions/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'add_questions'])->name('question_creation.add_questions');
    Route::post('/question_creation/get_options', [\App\Http\Controllers\QuestionCreationController::class, 'get_options'])->name('question_creation.get_options');
    Route::post('/question_creation/question_update', [\App\Http\Controllers\QuestionCreationController::class, 'question_update'])->name('question_creation.question_update');
    Route::get('/question_creation/data_delete/{id}', [\App\Http\Controllers\QuestionCreationController::class, 'data_delete'])->name('question_creation.data_delete');
    Route::get('/questionnaire/form/editdata/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'FormEdit'])->name('questionnaire_for_user.form.edit');
    Route::post('/questionnaire/update_toggle', [\App\Http\Controllers\QuestionCreationController::class, 'update_toggle'])->name('questionnaire.update_toggle');
    Route::get('/questionnaire/submitted/list', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubmittedForm'])->name('questionnaire.submitted.list');
    Route::get('/questionnaire/submitted/form/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'SubmittedForm'])->name('questionnaire.submitted.form');
    Route::get('/questionnaire/sensoryprofile/{id}', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'sensoryreport'])->name('questionnaire.sensoryreport');
    Route::post('/questionnaire/validation/type', [\App\Http\Controllers\QuestionCreationController::class, 'validationType'])->name('questionnaire.validation');

    //Questionnaire for Parents
    Route::resource('questionnaire_for_user', ParentsQuestionnaireController::class);
    Route::get('/questionnaire/form', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'fill_form'])->name('questionnaire_for_user.fill_form');
    Route::get('/questionnaire/fields/list', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllQuestionnaireFields'])->name('questionnaire_for_user.fields.list');
    Route::get('/questionnaire/field/dropdown/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllDropdownOptions'])->name('questionnaire_field.dropdown');
    Route::get('/questionnaire/field/radio/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllRadioOptions'])->name('questionnaire_field.radio');
    Route::get('/questionnaire/field/checkbox/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllCheckBoxOptions'])->name('questionnaire_field.checkbox');
    Route::get('/questionnaire/field/subdropdown/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubQuestionDropdownBoxOptions'])->name('questionnaire_field.subquestiondropdown');
    Route::get('/questionnaire/field/subradio/option', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GetAllSubQuestionRadioOptions'])->name('questionnaire_field.subquestionradio');
    Route::post('/questionnaire/form/save', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'QuestionnaireFormSave'])->name('questionnaire.form.save');
    Route::post('/questionnaire/form/submit', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'QuestionnaireFormSubmit'])->name('questionnaire.form.submit');
    Route::post('/questionnaire/graph/getdata', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'GraphGetdata'])->name('questionnaire.graph.getdata');
    Route::post('/sail/GetQuestionnaire', [\App\Http\Controllers\UserregisterfeeController::class, 'GetQuestionnaire'])->name('sail.get_questionnaire');
    Route::post('/sail/GetIsCo', [\App\Http\Controllers\UserregisterfeeController::class, 'GetIsCoordinator'])->name('sail.get_coordinator');

    //reports
    Route::get('/auditlog/login_report', [\App\Http\Controllers\ReportController::class, 'login_index'])->name('auditlog.login_report');
    Route::post('/auditlog/login_search_report', [\App\Http\Controllers\ReportController::class, 'login_search'])->name('auditlog.login_search_report');

    //auditlog
    Route::get('/auditlog/login_index', [\App\Http\Controllers\AuditlogController::class, 'login_index'])->name('auditlog.login_index');
    Route::match(['get', 'post'], '/auditlog/login', [\App\Http\Controllers\AuditlogController::class, 'login_search'])->name('auditlog.login');
    //video upload creation
    Route::resource('video_creation', ParentvideouploadController::class);
    Route::get('/parent_video_upload/parentindex', [\App\Http\Controllers\ParentvideouploadController::class, 'parentindex'])->name('parent_video_upload.parentindex');
    Route::get('/parent_video_upload/parent_create/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'parent_create'])->name('parent_video_upload.parent_create');
    Route::get('/activitymaster/show_1/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'show_1'])->name('activitymaster.show_1');
    Route::get('/activitymaster/edit_1/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'edit_1'])->name('activitymaster.edit_1');
    Route::get('/activity/materials/mapping/{id}', [\App\Http\Controllers\ParentvideouploadController::class, 'activity_materials'])->name('activitymaster.mapping');
    Route::post('/activity/materials/mapping/store', [\App\Http\Controllers\ParentvideouploadController::class, 'activity_materials_store'])->name('activity.mapping.store');
    Route::get('/parent_video_upload/initiate', [\App\Http\Controllers\ParentvideouploadController::class, 'activity_initiate'])->name('parent_video_upload.initiate');
    Route::post('/videocreation/parentstore', [App\Http\Controllers\ParentvideouploadController::class, 'parent_store'])->name('videocreation.parentstore');
    Route::post('/video/reupload/parent/bulk', [App\Http\Controllers\ParentvideouploadController::class, 'reupload_bulk'])->name('videocreation.parentstore.reupload.bulk');
    Route::post('/videocreation/parentstore/bulk', [App\Http\Controllers\ParentvideouploadController::class, 'parent_store_bulk'])->name('video.parentstore.bulk');
    Route::post('/videocreation/policyaggrement', [App\Http\Controllers\ParentvideouploadController::class, 'policy_aggrement'])->name('videocreation.policyaggrement');
    Route::get('/videocreation/delete/{id}', [App\Http\Controllers\ParentvideouploadController::class, 'delete'])->name('video_creation.delete');
    Route::post('/activity/create/action', [App\Http\Controllers\ParentvideouploadController::class, 'activityAction'])->name('activity.skill.action');

    // Assessment Mapping
    Route::resource('assessment_mapping', AssessmentMapping::class);
    Route::post('/assessment/skill/getdetails', [\App\Http\Controllers\AssessmentMapping::class, 'GetDetails'])->name('assessment.getdetails');
    Route::POST('/store/new/assessment/skill', [App\Http\Controllers\AssessmentMapping::class, 'NewAssesmentSkill'])->name('assessment.skill.store');
    //assessment report
    Route::resource('assessment_report', assessmentreportController::class);
    Route::get('/report/assessmentreport', [App\Http\Controllers\assessmentreportController::class, 'index'])->name('assessmentreport.index');
    Route::get('/report/assessmentreport/create', [App\Http\Controllers\assessmentreportController::class, 'create'])->name('assessmentreport.create');
    Route::POST('/report/assessment/new/store', [App\Http\Controllers\assessmentreportController::class, 'new_store'])->name('report.new');
    Route::POST('/report/assessment/new/store/auto', [App\Http\Controllers\assessmentreportController::class, 'auto_store'])->name('report.auto');
    Route::get('/report/assessmentreport/edit/{id}', [App\Http\Controllers\assessmentreportController::class, 'edit'])->name('assessmentreport.edit');
    Route::get('/report/recommendation/edit/{id}', [App\Http\Controllers\assessmentreportController::class, 'recommendation_edit'])->name('recommendation.edit');
    Route::POST('/report/assessment/new/update', [App\Http\Controllers\assessmentreportController::class, 'new_update'])->name('report.update');
    Route::post('/report/sail/report', [App\Http\Controllers\assessmentreportController::class, 'assessment_report'])->name('report_sail_download');
    Route::POST('/report/recommendation/new/store', [App\Http\Controllers\assessmentreportController::class, 'recommendation_new_store'])->name('report.recommendation_new_store');
    Route::get('/report/recommendation/create', [App\Http\Controllers\assessmentreportController::class, 'create_data'])->name('recommendation.create');
    Route::get('/report/recommendation/show/{id}', [App\Http\Controllers\assessmentreportController::class, 'Recomendation_show'])->name('recommendation.preview');
    Route::POST('/report/recommendation/new/update', [App\Http\Controllers\assessmentreportController::class, 'recommendation_update'])->name('report.recommendationupdate');
    Route::POST('/report/assessment/generatePDF', [App\Http\Controllers\assessmentreportController::class, 'generatePDF'])->name('recommendation.generatePDF');
    Route::POST('/report/assessment/generatePDFAssessment', [App\Http\Controllers\assessmentreportController::class, 'generatePDFAssessment'])->name('assessment.generatePDFAssessment');
    Route::post('/pdfdownload', [App\Http\Controllers\LoginController::class, 'pdfdownload']);
    Route::get('/sail_reports_list', [\App\Http\Controllers\assessmentreportController::class, 'report_list'])->name('report_list');
    Route::match(['get', 'post'], '/assessment-report-preview/{id}', [App\Http\Controllers\assessmentreportController::class, 'AssesmentReportPreview'])->name('assessment.report.preview');
    Route::match(['get', 'post'], '/assessment-report-save/{id}', [App\Http\Controllers\assessmentreportController::class, 'SummaryReportSave'])->name('assessment.report.SummaryReportSave');
    Route::get('/assessment-report-show/{id}', [App\Http\Controllers\assessmentreportController::class, 'AssesmentReportPreview1'])->name('assessment.report.preview1');
    Route::match(['get', 'post'], '/assessment-report-preview-render/{id}', [App\Http\Controllers\assessmentreportController::class, 'AssesmentReportRenderPreview'])->name('assessment.report.render');
    Route::match(['get', 'post'], '/recommendation-report-preview/{id}', [App\Http\Controllers\assessmentreportController::class, 'RecomendationPreview'])->name('recommendation.report.render');
    Route::get('/recommendation-report-show/{id}', [App\Http\Controllers\assessmentreportController::class, 'RecomendationPreview1'])->name('recommendation.report.render1');
    Route::match(['get', 'post'], '/referral-report-preview/{id}', [App\Http\Controllers\ReferralReportController::class, 'ReferralPreview'])->name('referral.report.render');
    Route::POST('/assessment/report/republish', [App\Http\Controllers\assessmentreportController::class, 'reportRepublish'])->name('report.republish');
    Route::get('/assessment/report/get/comments', [App\Http\Controllers\assessmentreportController::class, 'getComments'])->name('report.getComments');

    //recommendation report
    Route::get('/report/recommendationreport', [App\Http\Controllers\assessmentreportController::class, 'index_data'])->name('recommendation.index');
    Route::post('/areaname/master/ajax', [\App\Http\Controllers\assessmentreportController::class, 'areaname_ajax'])->name('areaname.ajax');

    //Reports Master
    Route::resource('reports_master', MasterAssessmentreportController::class);
    Route::get('/master/assessment', [App\Http\Controllers\MasterAssessmentreportController::class, 'index'])->name('asessmentreportmaster.index');
    Route::get('/master/assessment/create', [App\Http\Controllers\MasterAssessmentreportController::class, 'create'])->name('asessmentreportmaster.create');
    Route::POST('/master/assessment/header', [App\Http\Controllers\MasterAssessmentreportController::class, 'master_header'])->name('asessmentreportmaster.header');
    Route::POST('/master/assessment/store', [App\Http\Controllers\MasterAssessmentreportController::class, 'store'])->name('asessmentreportmaster.store');
    Route::get('/master/assessment/edit/{id}', [App\Http\Controllers\MasterAssessmentreportController::class, 'edit'])->name('assessmentreportmaster.edit');
    Route::get('/master/assessment/newversion/{id}', [App\Http\Controllers\MasterAssessmentreportController::class, 'NewVersion'])->name('reportmaster.newversion');
    Route::POST('/master/assessment/header/update', [App\Http\Controllers\MasterAssessmentreportController::class, 'update_header'])->name('reportmaster.update');
    Route::get('/master/preview/{id}', [App\Http\Controllers\MasterAssessmentreportController::class, 'publish_preview'])->name('reports_master.publish_preview');
    Route::POST('/master/final/submit', [App\Http\Controllers\MasterAssessmentreportController::class, 'final_submit'])->name('reportmaster.final_submit');
    Route::post('/reports_master/update_toggle', [\App\Http\Controllers\MasterAssessmentreportController::class, 'update_toggle'])->name('reportmaster.update_toggle');
    Route::POST('/master/assessment/report_store', [App\Http\Controllers\MasterAssessmentreportController::class, 'repot_store'])->name('asessmentreportmaster.report_store');

    //recommendation Report master
    Route::resource('areas_master', AreasMasterController::class);
    Route::POST('/area/master/recommendation/store', [App\Http\Controllers\AreasMasterController::class, 'store_data'])->name('recommendationreport.store_data');
    Route::get('/areas/master/data_edit/{id}', [App\Http\Controllers\AreasMasterController::class, 'edit'])->name('recommendationreport.edit');
    Route::POST('/areas/master/update_data', [App\Http\Controllers\AreasMasterController::class, 'update'])->name('recommendationreport.update');
    Route::get('/area/master/delete/{id}', [App\Http\Controllers\AreasMasterController::class, 'delete'])->name('recommendationreport.delete');

    //recommendation_master_table
    Route::resource('master_table', RecommendationMasterController::class);

    //faq(viruma)
    Route::get('/faqmodules/delete/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'delete'])->name('faqmodules.delete');
    Route::resource('/faqmodules', FAQmodulesController::class);
    Route::post('/FAQ_modules/update_data', [\App\Http\Controllers\FAQmodulesController::class, 'update_data'])->name('FAQ_modules.update_data');

    //question(viruma)
    Route::post('/profile_update', [\App\Http\Controllers\LoginController::class, 'profile_update'])->name('user.profile_update');
    Route::resource('/FAQ_questions', FAQquestionsController::class);
    Route::get('/profilepage', [\App\Http\Controllers\LoginController::class, 'profilepage'])->name('profilepage');
    Route::get('/FAQ_main', [\App\Http\Controllers\FAQController::class, 'main_index'])->name('main_index');
    Route::get('/FAQ_questions/delete/{id}', [\App\Http\Controllers\FAQquestionsController::class, 'delete'])->name('FAQ_questions.delete');
    Route::get('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'index'])->name('auditlog.activity1');
    Route::post('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'search'])->name('auditlog.activity');
    Route::post('/FAQ_questions/update_data', [\App\Http\Controllers\FAQquestionsController::class, 'update_data'])->name('FAQ_questions.update_data');
    Route::post('/FAQ_questions/update_toggle', [\App\Http\Controllers\FAQquestionsController::class, 'update_toggle'])->name('FAQ_questions.update_toggle');

    //activity initiation
    Route::resource('activity_initiate', activityInitiationController::class);
    Route::post('/activity_initiate/update_toggle', [\App\Http\Controllers\activityInitiationController::class, 'update_toggle'])->name('activity_initiate.update_toggle');
    Route::get('activity_initiate/store', [\App\Http\Controllers\activityInitiationController::class, 'store']);
    Route::get('activity_initiate_reload/{id}', [App\Http\Controllers\activityInitiationController::class, 'reload']);
    Route::post('activity/video/update', [\App\Http\Controllers\activityInitiationController::class, 'activity_update'])->name('activity.update.video');
    Route::post('activity/video/save', [\App\Http\Controllers\activityInitiationController::class, 'activity_save'])->name('activity.save.video');
    Route::get('activityinitiate/observation/{id}', [\App\Http\Controllers\activityInitiationController::class, 'observation'])->name('activityinitiate.observation');
    Route::post('activityinitiate/observationrecord/{id}', [\App\Http\Controllers\activityInitiationController::class, 'observationrecord'])->name('activityinitiate.observationrecord');
    Route::post('activityinitiate/activeStatus/{id}', [\App\Http\Controllers\activityInitiationController::class, 'activeStatus'])->name('activity_initiate.activeStatus');
    Route::post('activity/f2f/store', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fstore'])->name('activity_f2f.store');
    Route::get('activity/f2f/show/{id}', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fshow'])->name('activity_f2f.show');
    Route::get('activity/f2f/edit/{id}', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fedit'])->name('activity_f2f.edit');
    Route::post('activity/f2f/update', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fupdate'])->name('activity_f2f.update');
    Route::get('activity/f2f/delete/{id}', [\App\Http\Controllers\activityInitiationController::class, 'activity_f2fdelete'])->name('activity_f2f.delete');
    Route::get('/activity/f2f/fetch', [activityInitiationController::class, 'fetch'])->name('activity.f2ffetch');

    //Questinnaire Master
    Route::resource('/questionnaire_master', QuestionnaireMasterCreation::class);
    Route::post('/questionnaire_master/search', [\App\Http\Controllers\QuestionnaireMasterCreation::class, 'search'])->name('questionnaire_master.search');
    Route::post('/questionnaire_master/update_data', [\App\Http\Controllers\QuestionnaireMasterCreation::class, 'update_data'])->name('questionnaire_master.update_data');
    Route::get('/questionnaire_master/delete/{id}', [\App\Http\Controllers\QuestionnaireMasterCreation::class, 'delete'])->name('questionnaire_master.delete');
    Route::post('/questionnaire_master/update_toggle', [\App\Http\Controllers\QuestionnaireMasterCreation::class, 'update_toggle'])->name('questionnaire_master.update_toggle');
    Route::post('/questionnaire_master/department_category_get', [\App\Http\Controllers\QuestionnaireMasterCreation::class, 'department_category_get'])->name('questionnaire_master.department_category_get');
    Route::get('/calendar/event/getdata', [\App\Http\Controllers\ovm1Controller::class, 'GetEventData'])->name('calendar.getdata');
    Route::get('ovm/questionnaire', [\App\Http\Controllers\ovm1Controller::class, 'ovm_questionnaire'])->name('ovm.questionnaire');

    //Profile
    Route::get('/privacy/update/{id}', [\App\Http\Controllers\HomeController::class, 'index1'])->name('privacy.update');
    Route::post('/privacy/publish', [\App\Http\Controllers\HomeController::class, 'publish'])->name('privacy.publish');
    Route::get('/user/status/view', [HomeController::class, 'status_view'])->name('status_view');
    Route::post('/lead/view/userdetails', [HomeController::class, 'lead_view'])->name('lead_view');
    Route::get('/search/Coordinators/view', [HomeController::class, 'searchCoordinators'])->name('searchCoordinators');

    //Referral Report
    Route::resource('referralreport', ReferralReportController::class);
    Route::post('/therapist/specialization/getuser', [\App\Http\Controllers\ReferralReportController::class, 'GetUser'])->name('therapist.getuser');
    Route::post('/report/referral/generatePDF', [\App\Http\Controllers\ReferralReportController::class, 'GeneratePDF'])->name('referral.generatePDF');
    // Face To Face Meetings
    Route::resource('inperson_meeting', InPersonMeetingController::class);
    Route::post('/get/sail/details', [\App\Http\Controllers\InPersonMeetingController::class, 'GetSailDetails']);
    Route::get('inperson/edit/meeting/{id}', [App\Http\Controllers\InPersonMeetingController::class, 'SentMeeting'])->name('SentMeeting');

    // Calendar
    Route::resource('calendar', CalendarController::class);
    Route::get('/calendar/availability/update', [CalendarController::class, 'AvailabilityUpdate'])->name('calendar.availability');
    Route::get('/calendar/event', [CalendarController::class, 'CalendarEvent'])->name('calendar.event');

    // Quadrent Questionnaire 
    Route::resource('quadrant_questionnaire', QuadrantQuestionnaireController::class);
    Route::get('/quadrant/questionnaire/executive/{id}', [QuadrantQuestionnaireController::class, 'executive_report'])->name('quadrant_questionnaire.executive');
    Route::post('/executive/report/update', [QuadrantQuestionnaireController::class, 'executive_report_update'])->name('executive_report_update');
    Route::post('/sensory/report/update', [QuadrantQuestionnaireController::class, 'sensory_report_update'])->name('sensory_report_update');

    // OVM Allocation
    Route::resource('ovm_allocation', OVMAllocationController::class);
    Route::get('ovm/allocation/details/{id}', [OVMAllocationController::class, 'ovm_accept'])->name('ovm.allocation.details');
    Route::post('ovm/allocation/user_update', [OVMAllocationController::class, 'user_update'])->name('ovm.allocation.user_update');
    Route::get('ovm_allocation/accept/{id}', [OVMAllocationController::class, 'user_edit'])->name('user_edit');
    Route::get('ovm_allocation/saved/{id}', [OVMAllocationController::class, 'saved'])->name('ovm_allocation.saved');

    // SAIL Republish
    Route::resource('report-republish', SailReportRepublish::class);


    Route::get('/files', [ReportFileController::class, 'index'])->name('files.index');
    Route::get('/files/view/{filename}', [ReportFileController::class, 'show'])->name('files.show');
    Route::get('/files/download/{filename}', [ReportFileController::class, 'download'])->name('files.download');


    //COMPASS
    Route::resource('compass', CompassController::class);
    Route::get('/compassstatus', [App\Http\Controllers\CompassController::class, 'index'])->name('compassstatus');
    Route::get('/compass/initiate/new', [App\Http\Controllers\CompassController::class, 'CompassInitiate'])->name('compassstatus.initiate');
    Route::post('/compassstatus/store', [App\Http\Controllers\CompassController::class, 'store'])->name('compass_store');

    //COMPASS PAYMENT   
    Route::get('/register/compass/compasscreate', [\App\Http\Controllers\UserregisterfeeController::class, 'compass_create_data'])->name('compass_register_fee');
    Route::post('/compassregisterfee/store_data', [App\Http\Controllers\UserregisterfeeController::class, 'compass_store_data'])->name('compass_store_data');
    Route::get('/compassregisterfee/show_data/{id}', [App\Http\Controllers\UserregisterfeeController::class, 'compass_show'])->name('compass_show');


    //Therapist Allocation
    Route::resource('therapistallocation', TherapistAllocationController::class);
    Route::get('/therapist', [App\Http\Controllers\TherapistAllocationController::class, 'index'])->name('therapist.index');
    Route::get('/therapist/initation', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistInit'])->name('TherapistInit');
    Route::post('/therapist/specialization', [App\Http\Controllers\TherapistAllocationController::class, 'Therapistspecialization'])->name('Therapistspecialization');
    Route::get('/therapist/list', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistList'])->name('TherapistList');
    Route::get('/therapist/list/show/{id}', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistListShow'])->name('TherapistListShow');
    Route::get('/therapist/details/list', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistdetailsList'])->name('TherapistdetailsList');
    Route::get('/therapist/details/list/show/{id}', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistdetailsListShow'])->name('TherapistdetailsListShow');
    Route::get('/TherapistdetailsListedit/{id}', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistdetailsListedit'])->name('TherapistdetailsListedit');
    Route::post('/therapist/details/list/update', [App\Http\Controllers\TherapistAllocationController::class, 'TherapistdetailsListupdate'])->name('TherapistdetailsListupdate');
    Route::get('/parents/review/invite', [App\Http\Controllers\TherapistAllocationController::class, 'Parentsreviewinvite'])->name('Parentsreviewinvite');
    Route::get('/therapist/review/invite', [App\Http\Controllers\TherapistAllocationController::class, 'Therapistreviewinvite'])->name('Therapistreviewinvite');
    Route::post('/therapist/specialization/review', [App\Http\Controllers\TherapistAllocationController::class, 'Therapistspecializationreview'])->name('Therapistspecializationreview');
    Route::resource('therapistallocationview', TherapistAllocationViewController::class);
    Route::get('/therapistallocationview', [App\Http\Controllers\TherapistAllocationViewController::class, 'index'])->name('therapistallocationview.index');

    //Meeting Allocation and Review Meeting
    Route::get('/meetinglist', [App\Http\Controllers\MeetingController::class, 'index'])->name('meeting.index');
    Route::get('/meetinglist/weeklysent/list/edit/{id}', [App\Http\Controllers\MeetingController::class, 'Edit'])->name('SessionMeetingSentEdit');
    Route::get('/therapist/weeklysent/list/show/{id}', [App\Http\Controllers\MeetingController::class, 'Show'])->name('SessionMeetingSentShow');
    Route::get('/parents/review/show/{id}', [App\Http\Controllers\MeetingController::class, 'Parentsreviewshow'])->name('Parentsreviewshow');
    Route::get('/parents/review/edit/{id}', [App\Http\Controllers\MeetingController::class, 'Parentsreviewedit'])->name('Parentsreviewedit');
    Route::get('/parents/review/sent/show/{id}', [App\Http\Controllers\MeetingController::class, 'Parentsreviewsentshow'])->name('Parentsreviewsentshow');
    Route::get('/parents/review/sent/edit/{id}', [App\Http\Controllers\MeetingController::class, 'Parentsreviewsentedit'])->name('Parentsreviewsentedit');
    Route::get('/therapist/review/show/{id}', [App\Http\Controllers\MeetingController::class, 'therapistreviewshow'])->name('therapistreviewshow');
    Route::get('/therapist/review/edit/{id}', [App\Http\Controllers\MeetingController::class, 'therapistreviewedit'])->name('therapistreviewedit');
    Route::get('/therapist/review/sent/show/{id}', [App\Http\Controllers\MeetingController::class, 'therapistreviewsentshow'])->name('therapistreviewsentshow');
    Route::get('/therapist/review/sent/edit/{id}', [App\Http\Controllers\MeetingController::class, 'therapistreviewsentedit'])->name('therapistreviewsentedit');



    //Progress search
    Route::get('/progress/status', [App\Http\Controllers\TherapistAllocationController::class, 'progressstatus'])->name('progressstatus');
    Route::get('/externaltherapist', [App\Http\Controllers\TherapistAllocationController::class, 'ExternalAllocation'])->name('ExternalAllocation');

    //Compass meeting
    Route::resource('compassmeeting', CompassMeetingController::class);
    Route::get('/compassmeeting', [App\Http\Controllers\CompassMeetingController::class, 'index'])->name('compassmeeting');
    Route::get('/CompassNewmeetinginvite', [App\Http\Controllers\CompassMeetingController::class, 'CompassNewmeetinginvite'])->name('CompassNewmeetinginvite');
    // Route::post('/compassmeeting/store', [\App\Http\Controllers\CompassMeetingController::class, 'store']);
    // Route::get('/compassmeeting/show/{id}', [App\Http\Controllers\CompassMeetingController::class, 'show']);
    // Route::get('/compassmeeting/edit/{id}', [App\Http\Controllers\CompassMeetingController::class, 'edit']);
    // Route::post('/compassmeeting/update/{id}', [\App\Http\Controllers\CompassMeetingController::class, 'update']);

    //Home Tracker
    Route::resource('hometracker', HomeTrackerController::class);
    Route::get('/hometracker', [App\Http\Controllers\HomeTrackerController::class, 'index'])->name('hometracker');
    // Route::post('/hometracker/store', [\App\Http\Controllers\HomeTrackerController::class, 'store']);
    Route::get('/hometracker/parentinitiate/new/{id}', [App\Http\Controllers\HomeTrackerController::class, 'viewform'])->name('hometracker.viewform');
    Route::post('/hometracker/viewcal', [App\Http\Controllers\HomeTrackerController::class, 'viewcalendar'])->name('viewcale');
    Route::get('/hometrackerInit', [App\Http\Controllers\HomeTrackerController::class, 'hometrackerInit'])->name('hometrackerInit');

    //Weekly feedback
    Route::resource('weeklyfeedback', WeeklyFeedbackController::class);
    Route::get('/weeklyfeedback', [App\Http\Controllers\WeeklyFeedbackController::class, 'index'])->name('index');

    //Observation
    Route::resource('compassobservation', CompassObservationController::class);
    Route::get('/compassobservation', [App\Http\Controllers\CompassObservationController::class, 'index'])->name('compassobservation.index');
    Route::get('/monthlyobservation', [App\Http\Controllers\CompassObservationController::class, 'monthlyindex'])->name('monthlyindex');
    Route::get('/monthlytab', [App\Http\Controllers\CompassObservationController::class, 'monthlytab'])->name('monthlytab');

    //Monthly Observation
    Route::get('/monthlycompassobservation', [App\Http\Controllers\CompassObservationController::class, 'monthlyobservationindex'])->name('monthlycompassobservation.index');
    Route::get('/overallmonthlycompassobservation', [App\Http\Controllers\CompassObservationController::class, 'overallmonthlyobservationindex'])->name('overallmonthlycompassobservation.index');

    //Master observation
    Route::resource('strengthobservation', MasterObservationController::class);
    Route::get('/strengthobservation', [App\Http\Controllers\MasterObservationController::class, 'index'])->name('strengthobservation.index');
    Route::get('/sourcestrength', [App\Http\Controllers\MasterObservationController::class, 'sourcestrengthindex'])->name('sourcestrength.index');
    Route::get('/environmentstrength', [App\Http\Controllers\MasterObservationController::class, 'environmentstrengthindex'])->name('environmentstrength.index');
    Route::get('/stretchobservation', [App\Http\Controllers\MasterObservationController::class, 'stretchindex'])->name('stretchobservation.stretchindex');

    //Observation Notes Reference

    //Monthly Objective
    Route::resource('monthlyobjective', MonthlyObjectiveController::class);
    Route::get('/monthlyobjective', [App\Http\Controllers\MonthlyObjectiveController::class, 'index'])->name('monthlyobjective.index');
    Route::get('/monthly/viewcal', [App\Http\Controllers\MonthlyObjectiveController::class, 'listcalendar'])->name('monthlyobjectiveviewcalendar');
    Route::get('/monthly/objectivequestion/new/{id}', [App\Http\Controllers\MonthlyObjectiveController::class, 'viewform'])->name('monthlyobjectives.viewform');

    //Child Website
    Route::resource('childwebsite', ChildWebsiteController::class);
    Route::get('/childwebsite', [App\Http\Controllers\ChildWebsiteController::class, 'index'])->name('childwebsite.index');

    //Question creation for compass
    Route::resource('compassquestion_creation', CompassQuestionCreationController::class);
    Route::get('/compassquestion_creation', [App\Http\Controllers\CompassQuestionCreationController::class, 'index'])->name('compassquestion_creation');
    Route::get('/compassquestion_creation/create', [App\Http\Controllers\CompassQuestionCreationController::class, 'create'])->name('compassquestion_creation.create');


    //Coordinator Allocation of ovm
    Route::resource('coordinator_allocation', CoordinatorAllocationController::class);
    Route::get('/coordinator_allocation', [App\Http\Controllers\CoordinatorAllocationController::class, 'index'])->name('coordinator_allocation.index');
    Route::get('/coordinator/list/view', [App\Http\Controllers\CoordinatorAllocationController::class, 'list'])->name('coordinator.list');
    Route::get('/coordinator/show/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'show'])->name('coordinator.show');
    Route::get('/allocation/list', [App\Http\Controllers\CoordinatorAllocationController::class, 'child_list'])->name('coordinator.childlist');
    Route::post('/coordinator/allocation/store', [App\Http\Controllers\CoordinatorAllocationController::class, 'allocate_store'])->name('coordinator.allocate_store');
    Route::get('/coordinator/edit/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'edit'])->name('coordinator.edit');
    Route::post('/coordinator/reallocation/update', [App\Http\Controllers\CoordinatorAllocationController::class, 'reallocation'])->name('coordinator.reallocation');
    Route::get('/coordinator/cancellation/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'cancellation'])->name('coordinator.cancellation');
    Route::post('/coordinator/cancellation/store', [App\Http\Controllers\CoordinatorAllocationController::class, 'cancellation_store'])->name('coordinator.cancellation_store');


    Route::get('coordinator/allocation/details/{id}', [CoordinatorAllocationController::class, 'ovm_accept'])->name('ovm_allocation.details');

    //OVM ALLOCATION

    Route::get('/coordinator/ovm_create/{id}', [App\Http\Controllers\CoordinatorAllocationController::class, 'ovm_create'])->name('coordinator_allocation.ovm_create');
    Route::post('ovm_allocation/store', [App\Http\Controllers\CoordinatorAllocationController::class, 'ovm_store'])->name('ovm.allocation.ovm_store');

    Route::get('/meeting/date/validation', [App\Http\Controllers\CoordinatorAllocationController::class, 'date_validation'])->name('coordinator_allocation.date_validation');


    //calendar 
    Route::get('/ovmmeetingview', [App\Http\Controllers\CoordinatorAllocationController::class, 'calendar_list'])->name('meetingallocationview.list');


    //Email Template
    Route::resource('emailtemplate', EmailTemplateController::class);
    Route::put('sail/complete/{id}', [App\Http\Controllers\SaildocumentController::class, 'sail_complete'])->name('sail.complete');

    //
    Route::resource('performancearea', PerformanceAreaController::class);

    //
    Route::resource('swot_master', SWOTMasterController::class);

    // ConversationManagerController
    Route::resource('conversationmanager', ConversationMasterController::class);
    Route::get('/gformmaster', [App\Http\Controllers\ConversationMasterController::class, 'G2_Index'])->name('master.gform.index');
    Route::post('/gform/master/submit', [App\Http\Controllers\ConversationMasterController::class, 'G2_Store'])->name('master.gform.store');
    Route::post('/gform/master/update', [App\Http\Controllers\ConversationMasterController::class, 'G2_Update'])->name('master.gform.update');
    Route::get('/conversationsummerymaster', [App\Http\Controllers\ConversationMasterController::class, 'Summery_Index'])->name('master.summery.index');

    //13+ questionnaire
    Route::resource('thirteenyrs_mgmnt', AboveagemanagementController::class);
    //Question Creation
    Route::resource('thirteenyrsquestion_creation', MasterQuestionCreationController::class);
    Route::get('/thirteenquestion_creation/add_questions/{id}', [\App\Http\Controllers\MasterQuestionCreationController::class, 'add_questions'])->name('thirteenquestion_creation.add_questions');
    Route::post('/thirteenquestionnaire/update_toggle', [\App\Http\Controllers\MasterQuestionCreationController::class, 'update_toggle'])->name('thirteenquestionnaire.update_toggle');
    Route::get('/thirteenquestionnaire/data_delete/{id}', [\App\Http\Controllers\MasterQuestionCreationController::class, 'data_delete'])->name('thirteenquestionnaire.data_delete');
    Route::post('/thirteenquestion_creation/get_options', [\App\Http\Controllers\MasterQuestionCreationController::class, 'get_options'])->name('thirteenquestion_creation.get_options');
    Route::post('/thirteenquestion_creation/question_update', [\App\Http\Controllers\MasterQuestionCreationController::class, 'question_update'])->name('thirteenquestion_creation.question_update');

    //Questionaire Master
    Route::resource('/thirteenyrsquestionnaire_master', MasterQuestionnaireCreationController::class);
    Route::get('/thirteenyrsquestionnaire_master/delete/{id}', [\App\Http\Controllers\MasterQuestionnaireCreationController::class, 'delete'])->name('thirteenquestionnaire_master.delete');

    //Questionaire Allocation
    Route::resource('questionnaire_allocation13', thirteenyrsquestionnaireallocation::class);
    Route::get('/questionnaire/preview', [\App\Http\Controllers\thirteenyrsquestionnaireallocation::class, 'preview'])->name('questionnaire_allocation13.get_preview');

    //Child Questionnaire

    //Questionnaire for Parents
    Route::resource('questionnaire_for_child', ChildQuestionnaireController::class);
    Route::get('/childquestionnaire/form', [\App\Http\Controllers\ChildQuestionnaireController::class, 'fill_form'])->name('childquestionnaire_for_user.fill_form');
    Route::get('/childquestionnaire/fields/list', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllQuestionnaireFields'])->name('childquestionnaire_for_user.fields.list');
    Route::get('/childquestionnaire/field/dropdown/option', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllDropdownOptions'])->name('childquestionnaire_for_user.dropdown');
    Route::get('/childquestionnaire/field/radio/option', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllRadioOptions'])->name('childquestionnaire_for_user.radio');
    Route::get('/childquestionnaire/field/checkbox/option', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllCheckBoxOptions'])->name('childquestionnaire_for_user.checkbox');
    Route::get('/childquestionnaire/field/subdropdown/option', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllSubQuestionDropdownBoxOptions'])->name('childquestionnaire_for_user.subquestiondropdown');
    Route::get('/childquestionnaire/field/subradio/option', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GetAllSubQuestionRadioOptions'])->name('childquestionnaire_for_user.subquestionradio');
    Route::post('/childquestionnaire/form/save', [\App\Http\Controllers\ChildQuestionnaireController::class, 'QuestionnaireFormSave'])->name('childquestionnaire_for_user.form.save');
    Route::post('/childquestionnaire/form/submit', [\App\Http\Controllers\ChildQuestionnaireController::class, 'QuestionnaireFormSubmit'])->name('childquestionnaire_for_user.form.submit');
    Route::post('/childquestionnaire/graph/getdata', [\App\Http\Controllers\ChildQuestionnaireController::class, 'GraphGetdata'])->name('childquestionnaire_for_user.graph.getdata');
    Route::get('/childquestionnaire/form/editdata/{id}', [\App\Http\Controllers\ChildQuestionnaireController::class, 'FormEdit'])->name('childquestionnaire_for_user.form.edit');
    Route::get('/childquestionnaire/submitted/form/{id}', [\App\Http\Controllers\ChildQuestionnaireController::class, 'SubmittedForm'])->name('childquestionnaire_for_user.submitted.form');

    //Activity Allocation
    Route::resource('activity_allocation13', thirteenyrsactivityallocation::class);
    Route::post('/activity_allocation13/update_toggle', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'update_toggle'])->name('activity_allocation13.update_toggle');
    Route::get('activity_allocation13/store', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'store']);
    Route::get('activity_allocation13_reload/{id}', [App\Http\Controllers\thirteenyrsactivityallocation::class, 'reload']);
    Route::post('activity_allocation13/video/update', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'activity_update'])->name('activity_allocation13.update.video');
    Route::post('activity_allocation13/video/save', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'activity_save'])->name('activity_allocation13.save.video');
    Route::get('activityallocation13/observation/{id}', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'observation'])->name('activity_allocation13.observation');
    Route::post('activityallocation13/observationrecord/{id}', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'observationrecord'])->name('activity_allocation13.observationrecord');
    Route::post('activityallocation13/activeStatus/{id}', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'activeStatus'])->name('activity_allocation13.activeStatus');
    Route::post('/parentvideo13/description', [\App\Http\Controllers\thirteenyrsactivityallocation::class, 'description'])->name('parentvideo13.description');

    //Child Upload Video Controller

    Route::get('/child_video_upload/childindex', [\App\Http\Controllers\childvideouploadController::class, 'index'])->name('child_video_upload.childindex');
    Route::get('/child_video_upload/parent_create/{id}', [\App\Http\Controllers\childvideouploadController::class, 'child_create'])->name('child_video_upload.child_create');

    //Auto save
    Route::post('/autosave/{id}', [App\Http\Controllers\ovm1Controller::class, 'autosave'])->name('autosave');

    //resend
    Route::get('ovmresent/{a}/{id}', [App\Http\Controllers\ovm1Controller::class, 'resend'])->name('ovm1resend');

    //assessment_activity
    Route::post('/report/assessmentreport/observation', [App\Http\Controllers\assessmentreportController::class, 'observation_view'])->name('assessmentreport.observation_view');

    //meeting_updation
    Route::post('/meeting_description_ass/update', [App\Http\Controllers\assessmentreportController::class, 'meetingdes_updation'])->name('assessmentreport.meetingdes_updation');

    //Questionnaire updation
    Route::post('/questionnaire/updateoption', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'upload_update'])->name('question.upload_update');
    Route::post('/questionnaire/updateoption/parent', [\App\Http\Controllers\ParentsQuestionnaireController::class, 'upload_update_parent'])->name('question.upload_update_parent');


    //Payment Master
    //recommendation Report master
    Route::resource('payment_master', MasterPaymentController::class);
    Route::POST('/payment/master/store', [App\Http\Controllers\MasterPaymentController::class, 'store_data'])->name('paymentmaster.store_data');
    Route::get('/payment/master/data_edit/{id}', [App\Http\Controllers\MasterPaymentController::class, 'edit_data'])->name('payment_master_edit_data');
    Route::POST('/payment/master/update_data', [App\Http\Controllers\MasterPaymentController::class, 'update'])->name('paymentmaster.update');
    Route::get('/payment/master/delete/{id}', [App\Http\Controllers\MasterPaymentController::class, 'delete'])->name('paymentmaster.delete');
    Route::post('/payment/master/show', [\App\Http\Controllers\MasterPaymentController::class, 'show'])->name('paymentmaster.show');
    Route::POST('/payment/master/toggle_data', [App\Http\Controllers\MasterPaymentController::class, 'toggle'])->name('paymentmaster.toggle');
    Route::POST('/payment/master/hold_data', [App\Http\Controllers\MasterPaymentController::class, 'hold'])->name('paymentmaster.hold');
    Route::POST('/payment/master/cancel', [App\Http\Controllers\MasterPaymentController::class, 'cancel'])->name('paymentmaster.cancel');

    Route::get('/payment/customized/sail', [App\Http\Controllers\CustomizedPaymentController::class, 'index'])->name('paymentmaster.customized');
    Route::get('/payment/customized/sail/create', [App\Http\Controllers\CustomizedPaymentController::class, 'create'])->name('paymentmaster.customized.create');
    Route::post('/payment/customized/sail/store', [App\Http\Controllers\CustomizedPaymentController::class, 'store_data'])->name('paymentmaster.customized.store');
    Route::get('/payment/customized/sail/getdata/{id}', [App\Http\Controllers\CustomizedPaymentController::class, 'getdata'])->name('paymentmaster.customized.getdata');
    Route::post('/payment/customized/sail/update', [App\Http\Controllers\CustomizedPaymentController::class, 'update'])->name('paymentmaster.customized.update');

    Route::get('/business/affiliate/{program}', [App\Http\Controllers\BusinessCategoryMasterController::class, 'index'])->name('business.affiliate');
    Route::get('/business/affiliate/{program}/create', [App\Http\Controllers\BusinessCategoryMasterController::class, 'create'])->name('business.affiliate.create');
    Route::post('/business/affiliate/store_data', [App\Http\Controllers\BusinessCategoryMasterController::class, 'store_data'])->name('business.affiliate.store');
    Route::get('/business/affiliate/{id}/edit', [App\Http\Controllers\BusinessCategoryMasterController::class, 'edit'])->name('business.affiliate.edit');
    Route::post('/business/affiliate/update_data', [App\Http\Controllers\BusinessCategoryMasterController::class, 'update_data'])->name('business.affiliate.update');
    // Route::get('/onboarding', [App\Http\Controllers\BusinessCategoryMasterController::class, 'edit_data'])->name('business.affiliate');

    Route::get('/service/briefing/master', [App\Http\Controllers\ServiceBriefingMasterController::class, 'ServiceBriefing'])->name('service.briefing');
    Route::get('/service/briefing/master/index', [App\Http\Controllers\ServiceBriefingMasterController::class, 'index'])->name('service.briefing.index');
    Route::get('/service/briefing/master/create', [App\Http\Controllers\ServiceBriefingMasterController::class, 'create'])->name('service.briefing.create');
    Route::post('/service/briefing/master/store', [App\Http\Controllers\ServiceBriefingMasterController::class, 'store_data'])->name('service.briefing.store');
    Route::get('/service/briefing/master/getdata/{id}', [App\Http\Controllers\ServiceBriefingMasterController::class, 'getdata'])->name('service.briefing.getdata');
    Route::post('/service/briefing/master/update', [App\Http\Controllers\ServiceBriefingMasterController::class, 'update'])->name('service.briefing.update');
});
