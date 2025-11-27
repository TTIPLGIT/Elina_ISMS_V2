<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('newenrollment.index', function (BreadcrumbTrail $trail) {
    $trail->push('Enrollment', route('newenrollment.index'));
});
Breadcrumbs::for('newenrollment.create', function (BreadcrumbTrail $trail) {
    $trail->parent('newenrollment.index');
    $trail->push('New Enrollment', route('newenrollment.create'));
});
Breadcrumbs::for('newenrollment.show', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('newenrollment.index');
    $trail->push('Show', route('newenrollment.show',$id));
});
Breadcrumbs::for('newenrollment.edit', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('newenrollment.index');
    $trail->push('Edit', route('newenrollment.edit',$id));
});

Breadcrumbs::for('auditlogs', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Audit Logs', route('auditlogs'));
});
Breadcrumbs::for('auditlog', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('Field Logs', route('auditlog'));
});
Breadcrumbs::for('Usercreation', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('User Creation', route('Usercreation'));
});

Breadcrumbs::for('userslog', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('User login', route('userslog'));
});

Breadcrumbs::for('publicform.show', function ($trail,$id) {
    $trail->parent('publicform.index');
    $trail->push($id, route('publicform.show',$id));
});

Breadcrumbs::for('publicform.edit', function ($trail,$id) {
    $trail->parent('publicform.index');
    $trail->push($id, route('publicform.edit',$id));
});


Breadcrumbs::for('uam_modules.index', function (BreadcrumbTrail $trail) {
    $trail->push('UAM Modules', route('uam_modules.index'));
});
Breadcrumbs::for('uam_modules.edit', function ($trail,$id) {
    $trail->parent('uam_modules.index');
    $trail->push('Edit', route('uam_modules.edit',$id));
});
Breadcrumbs::for('uam_modules.show', function ($trail,$id) {
    $trail->parent('uam_modules.index');
    $trail->push('Show', route('uam_modules.show',$id));
});
Breadcrumbs::for('uam_modules.create', function ($trail) {
    $trail->parent('uam_modules.index');
    $trail->push('Create', route('uam_modules.create'));
});
Breadcrumbs::for('uam_screens.index', function (BreadcrumbTrail $trail) {
    $trail->push('UAM Screens', route('uam_screens.index'));
});
Breadcrumbs::for('uam_screens.create', function ($trail) {
    $trail->parent('uam_screens.index');
    $trail->push('Create', route('uam_screens.create'));
});
Breadcrumbs::for('uam_screens.edit', function ($trail,$id) {
    $trail->parent('uam_screens.index');
    $trail->push('Edit', route('uam_screens.edit',$id));
});
Breadcrumbs::for('uam_screens.show', function ($trail,$id) {
    $trail->parent('uam_screens.index');
    $trail->push('Show', route('uam_screens.show',$id));
});
Breadcrumbs::for('uam_modules_screens.index', function (BreadcrumbTrail $trail) {
    $trail->push('UAM Modules Screens', route('uam_modules_screens.index'));
});
Breadcrumbs::for('uam_modules_screens.create', function ($trail) {
    $trail->parent('uam_modules_screens.index');
    $trail->push('Create', route('uam_modules_screens.create'));
});
Breadcrumbs::for('uam_modules_screens.edit', function ($trail,$id) {
    $trail->parent('uam_modules_screens.index');
    $trail->push('Edit', route('uam_modules_screens.edit',$id));
});
Breadcrumbs::for('uam_modules_screens.show', function ($trail,$id) {
    $trail->parent('uam_modules_screens.index');
    $trail->push('Show', route('uam_modules_screens.show',$id));
});
Breadcrumbs::for('uam_roles.index', function (BreadcrumbTrail $trail) {
    $trail->push('UAM Roles', route('uam_roles.index'));
});
Breadcrumbs::for('uam_roles.create', function ($trail) {
    $trail->parent('uam_roles.index');
    $trail->push('Create', route('uam_roles.create'));
});
Breadcrumbs::for('uam_roles.edit', function ($trail,$id) {
    $trail->parent('uam_roles.index');
    $trail->push('Edit', route('uam_roles.edit',$id));
});
Breadcrumbs::for('uam_roles.show', function ($trail,$id) {
    $trail->parent('uam_roles.index');
    $trail->push('Show', route('uam_roles.show',$id));
});
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->push('Users', route('user.index'));
});
Breadcrumbs::for('user.create', function ($trail) {
    $trail->parent('user.index');
    $trail->push("Create", route('user.create'));
});
Breadcrumbs::for('user.edit', function ($trail,$id) {
    $trail->parent('user.index');
    $trail->push("Edit", route('user.edit',$id));
});
Breadcrumbs::for('user.show', function ($trail,$id) {
    $trail->parent('user.index');
    $trail->push("Show", route('user.show',$id));
});
Breadcrumbs::for('user.change_password_admin', function ($trail,$id) {
    $trail->parent('user.index');
    $trail->push("Change Password", route('user.change_password_admin',$id));
});
Breadcrumbs::for('tokenmaster.index', function (BreadcrumbTrail $trail) {
    $trail->push('Token Master', route('tokenmaster.index'));
});
Breadcrumbs::for('internlist', function (BreadcrumbTrail $trail) {
    $trail->push('Intern Enrollment', route('internlist'));
});
Breadcrumbs::for('internview', function ($trail,$id) {
    $trail->parent('internlist');
    $trail->push("Show", route('internview',$id));
});
Breadcrumbs::for('servicelist', function (BreadcrumbTrail $trail) {
    $trail->push('Service Enrollment', route('servicelist'));
});
Breadcrumbs::for('serviceproviderview', function ($trail,$id) {
    $trail->parent('servicelist');
    $trail->push("Show", route('serviceproviderview',$id));
});
Breadcrumbs::for('enrollement.schoollist', function (BreadcrumbTrail $trail) {
    $trail->push('School Enrollment', route('enrollement.schoollist'));
});
Breadcrumbs::for('enrollement.schoolshow', function ($trail,$id) {
    $trail->parent('enrollement.schoollist');
    $trail->push("Show", route('enrollement.schoolshow',$id));
});

Breadcrumbs::for('sail_register_fee', function (BreadcrumbTrail $trail) {
    $trail->push('Sail Register fee', route('sail_register_fee'));
});
Breadcrumbs::for('userregisterfee.index', function (BreadcrumbTrail $trail) {
    $trail->push('Payment Status', route('userregisterfee.index'));
});
Breadcrumbs::for('userregisterfee.show', function ($trail,$id) {
    $trail->parent('userregisterfee.index');
    $trail->push("Show", route('userregisterfee.show',$id));
});
Breadcrumbs::for('userregisterfee.create', function ($trail) {
    $trail->parent('userregisterfee.index');
    $trail->push("User Registration Fee", route('userregisterfee.create'));
});
Breadcrumbs::for('payuserfee.index', function (BreadcrumbTrail $trail) {
    $trail->push('Payment Status', route('payuserfee.index'));
});
Breadcrumbs::for('payuserfee.create', function ($trail) {
    $trail->parent('payuserfee.index');
    $trail->push("Pay", route('payuserfee.create'));
});
Breadcrumbs::for('payuserfee.show', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('payuserfee.index');
    $trail->push('Show', route('payuserfee.show',$id));
});
Breadcrumbs::for('Newmeetinginvite.index', function (BreadcrumbTrail $trail) {
    $trail->push('Meeting Invite', route('Newmeetinginvite'));
});
Breadcrumbs::for('ovm1.index', function (BreadcrumbTrail $trail) {
    $trail->push('OVM-1', route('ovm1.index'));
});

Breadcrumbs::for('ovm1.show', function ($trail,$id) {
    $trail->parent('ovm1.index');
    $trail->push("Show", route('ovm1.show',$id));
});
Breadcrumbs::for('ovm1.edit', function ($trail,$id) {
    $trail->parent('ovm1.index');
    $trail->push("Edit", route('ovm1.edit',$id));
});
Breadcrumbs::for('enrollement.edit', function ($trail,$id) {
    $trail->parent('ovm1.index');
    $trail->push("Edit", route('enrollement.edit',$id));
});
Breadcrumbs::for('ovmsent', function ($trail,$id) {
    $trail->parent('ovm1.index');
    $trail->push("OVM Edit", route('ovmsent',$id));
});
Breadcrumbs::for('ovmreport', function (BreadcrumbTrail $trail) {
    $trail->push('OVM Report', route('ovmreport'));
});
Breadcrumbs::for('ovmreportview', function ($trail,$id) {
    $trail->parent('ovmreport');
    $trail->push("View", route('ovmreportview',$id));
});
Breadcrumbs::for('ovmmeetingcompleted', function (BreadcrumbTrail $trail) {
    $trail->push('Conversation Summary', route('ovmmeetingcompleted'));
});
Breadcrumbs::for('ovmcompleted', function ($trail) {
    $trail->parent('ovmmeetingcompleted');
    $trail->push("Edit", route('ovmcompleted'));
});
Breadcrumbs::for('ovm2.index', function (BreadcrumbTrail $trail) {
    $trail->push('OVM-2', route('ovm2.index'));
});
Breadcrumbs::for('ovm2.edit', function ($trail,$id) {
    $trail->parent('ovm2.index');
    $trail->push("Edit", route('ovm2.edit',$id));
});
Breadcrumbs::for('ovm2.show', function ($trail,$id) {
    $trail->parent('ovm2.index');
    $trail->push("Show", route('ovm2.show',$id));
});
Breadcrumbs::for('ovmsent2', function ($trail,$id) {
    $trail->parent('ovm2.index');
    $trail->push("OVM2 Edit", route('ovm2.show',$id));
});
Breadcrumbs::for('Newmeetinginvite', function ($trail) {
    $trail->parent('ovm1.index');
    $trail->push("Initiation", route('Newmeetinginvite'));
});
Breadcrumbs::for('Newmeetinginvite2', function ($trail) {
    $trail->parent('ovm2.index');
    $trail->push("Initiation", route('Newmeetinginvite2'));
});
Breadcrumbs::for('sailstatus', function (BreadcrumbTrail $trail) {
    $trail->push('Sail Status', route('sailstatus'));
});
Breadcrumbs::for('sailstatus.initiate', function ($trail) {
    $trail->parent('sailstatus');
    $trail->push("Sail Initiate", route('sailstatus.initiate'));
});
Breadcrumbs::for('sail.status.edit', function ($trail,$id) {
    $trail->parent('sailstatus');
    $trail->push("Sail Status Details", route('sail.status.edit',$id));
});
Breadcrumbs::for('sail.index', function (BreadcrumbTrail $trail) {
    $trail->push('Questionnaire List', route('sail.index'));
});
Breadcrumbs::for('activity_initiate.edit', function ($trail,$id) {
    $trail->parent('activity_initiate.index');
    $trail->push("Activity Edit", route('activity_initiate.edit',$id));
});
Breadcrumbs::for('activityinitiate.observation', function ($trail,$id) {
    $trail->parent('activity_initiate.index');
    $trail->push("Observation Notes", route('activityinitiate.observation',$id));
});
//faq(viruma)
Breadcrumbs::for('faqmodules.index', function (BreadcrumbTrail $trail) {
   
    $trail->push('FAQ Modules', route('faqmodules.index'));
});
Breadcrumbs::for('faqmodules.show', function ($trail,$id) {
    $trail->parent('faqmodules.index');
    $trail->push("Show", route('faqmodules.show',$id));
});
Breadcrumbs::for('faqmodules.edit', function ($trail,$id) {
    $trail->parent('faqmodules.index');
    $trail->push("Edit", route('faqmodules.edit',$id));
});
Breadcrumbs::for('FAQ_questions.index', function (BreadcrumbTrail $trail) {
   
    $trail->push('Manage FAQ', route('FAQ_questions.index'));
});
Breadcrumbs::for('FAQ_questions.edit', function ($trail,$id) {
    $trail->parent('FAQ_questions.index');
    $trail->push("Edit", route('FAQ_questions.edit',$id));
});
Breadcrumbs::for('FAQ_questions.show', function ($trail,$id) {
    $trail->parent('FAQ_questions.index');
    $trail->push("Show", route('FAQ_questions.show',$id));
});
//audit
Breadcrumbs::for('auditlog.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Login Details', route('auditlog.login'));
});
//activity set
Breadcrumbs::for('activitylog.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Activity Log', route('auditlog.activity'));
});
Breadcrumbs::for('activity_initiate.index', function (BreadcrumbTrail $trail) {
    $trail->push('Activity List', route('activity_initiate.index'));    
});
//Compass payment

Breadcrumbs::for('compass_show', function ($trail,$id) {
    $trail->parent('userregisterfee.index');
    $trail->push("Show", route('compass_show',$id));
});
Breadcrumbs::for('compass_register_fee', function ($trail) {
    $trail->parent('userregisterfee.index');
    $trail->push("Initiation", route('compass_register_fee'));
});
//Compass Meeting
Breadcrumbs::for('compassmeeting.index', function (BreadcrumbTrail $trail) {
    $trail->push('ORM', route('compassmeeting'));
});

Breadcrumbs::for('CompassNewmeetinginvite', function ($trail) {
    $trail->parent('compassmeeting.index');
    $trail->push("Initiation", route('CompassNewmeetinginvite'));
});
Breadcrumbs::for('compass.show', function ($trail,$id) {
    $trail->parent('compassmeeting.index');
    $trail->push("Show", route('compassmeeting.show',$id));
});
Breadcrumbs::for('compass.edit', function ($trail,$id) {
    $trail->parent('compassmeeting.index');
    $trail->push("Edit", route('compassmeeting.edit',$id));
});

//HomeTracker
Breadcrumbs::for('hometracker.index', function (BreadcrumbTrail $trail) {
    $trail->push('HT', route('hometracker'));
});

Breadcrumbs::for('activity_initiate.creat', function (BreadcrumbTrail $trail) {
    $trail->parent('activity_initiate.index');
    $trail->push('Activity Initiate', route('activity_initiate.create'));
});
Breadcrumbs::for('parent_video_upload.parentindex', function (BreadcrumbTrail $trail) {
    $trail->push('Activity List', route('parent_video_upload.parentindex'));
});
Breadcrumbs::for('parent_video_upload.parent_create', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('parent_video_upload.parentindex');
    $trail->push('Video Upload', route('parent_video_upload.parent_create',$id));
});   
Breadcrumbs::for('video_creation.create', function (BreadcrumbTrail $trail) {
    $trail->parent('video_creation.index');
    $trail->push('Create', route('video_creation.create'));
});
Breadcrumbs::for('video_creation.show', function ($trail,$id) {
    $trail->parent('video_creation.index');
    $trail->push("Show", route('video_creation.show',$id));
});
Breadcrumbs::for('video_creation.edit', function ($trail,$id) {
    $trail->parent('video_creation.index');
    $trail->push("Edit", route('video_creation.edit',$id));
});
Breadcrumbs::for('video_creation.index', function (BreadcrumbTrail $trail) {
    $trail->push("Activity Master", route('video_creation.index'));
});
//sail Questionnaire
Breadcrumbs::for('sail', function (BreadcrumbTrail $trail) {
    $trail->push("Questionnaireinitiation", route('sail'));
});
Breadcrumbs::for('question_creation.index', function (BreadcrumbTrail $trail) {
    $trail->push('Question Creation', route('question_creation.index'));
});
Breadcrumbs::for('question_creation.create', function (BreadcrumbTrail $trail) {
    $trail->parent('question_creation.index');
    $trail->push('Create', route('question_creation.create'));
});
Breadcrumbs::for('question_creation.show', function ($trail,$id) {
    $trail->parent('question_creation.index');
    $trail->push("Show", route('question_creation.show',$id));
});
Breadcrumbs::for('question_creation.add_questions', function ($trail,$id) {
    $trail->parent('question_creation.index');
    $trail->push("Edit", route('question_creation.add_questions',$id));
});
Breadcrumbs::for('questionnaire_master.index', function (BreadcrumbTrail $trail) {
    $trail->push('Questionnaire Master', route('questionnaire_master.index'));
});
Breadcrumbs::for('questionnaire_master.create', function (BreadcrumbTrail $trail) {
    $trail->parent('questionnaire_master.index');
    $trail->push('Create', route('questionnaire_master.create'));
});
Breadcrumbs::for('sail.sailquestionnaireinitiate', function (BreadcrumbTrail $trail) {
    $trail->push('Questionnaire Listview', route('sail.sailquestionnaireinitiate'));
});
Breadcrumbs::for('viewcalendar', function ($trail) {
    $trail->parent('hometracker.index');
    $trail->push("Calendar", route('viewcale'));
});
Breadcrumbs::for('asessmentreportmaster.index', function (BreadcrumbTrail $trail) {
    $trail->push('Report Master', route('asessmentreportmaster.index'));
});
Breadcrumbs::for('asessmentreportmaster.create', function ($trail) {
    $trail->parent('asessmentreportmaster.index');
    $trail->push("Create", route('asessmentreportmaster.create'));
});
Breadcrumbs::for('assessmentreportmaster.edit', function ($trail, $id) {
    $trail->parent('asessmentreportmaster.index');
    $trail->push("Add Pages", route('assessmentreportmaster.edit' , $id));
});
Breadcrumbs::for('reports_master.show', function ($trail, $id) {
    $trail->parent('asessmentreportmaster.index');
    $trail->push("Preview", route('reports_master.show' , $id));
});
Breadcrumbs::for('profilepage', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profilepage'));
});

//Therapist Allocation
//List View

Breadcrumbs::for('TherapistList', function (BreadcrumbTrail $trail) {
    $trail->push("TherapistList", route('TherapistList'));
});
Breadcrumbs::for('assessmentreport.index', function (BreadcrumbTrail $trail) {
    $trail->push('Assessment Report', route('assessmentreport.index'));
});
Breadcrumbs::for('assessmentreport.create', function ($trail) {
    $trail->parent('assessmentreport.index');
    $trail->push("Create", route('assessmentreport.create'));
});
Breadcrumbs::for('assessmentreport.edit', function ($trail,$id) {
    $trail->parent('assessmentreport.index');
    $trail->push("Edit", route('assessmentreport.edit',$id));
});
Breadcrumbs::for('assessment_report.show', function ($trail, $id) {
    $trail->parent('assessmentreport.index');
    $trail->push("Preview", route('assessment_report.show' , $id));
});

Breadcrumbs::for('sailquestionnairelistview', function (BreadcrumbTrail $trail) {
    $trail->push('SAIL Questionnaire', route('sailquestionnairelistview'));
});
Breadcrumbs::for('sailquestionnaireinitiate', function ($trail) {
    $trail->parent('sailquestionnairelistview');
    $trail->push("Initiate", route('sailquestionnaireinitiate'));
});
Breadcrumbs::for('ovm.questionnaire', function (BreadcrumbTrail $trail) {
    $trail->push('Parent Feedback Form', route('ovm.questionnaire'));
});
Breadcrumbs::for('ovm.questionnaire.initiate', function ($trail) {
    $trail->parent('ovm.questionnaire');
    $trail->push("Initiate", route('ovm.questionnaire.initiate'));
});
Breadcrumbs::for('questionnaire_for_user.index', function (BreadcrumbTrail $trail) {
    $trail->push('Questionnaire List', route('questionnaire_for_user.index'));
});

Breadcrumbs::for('TherapistdetailsListedit', function ($trail,$id) {
    $trail->parent('TherapistdetailsList');
    $trail->push("Edit", route('TherapistdetailsListedit',$id));
});
Breadcrumbs::for('questionnaire_for_user.form.edit', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('questionnaire_for_user.index');
    $trail->push('Form Edit', route('questionnaire_for_user.form.edit',$id));
});
Breadcrumbs::for('questionnaire.submitted.form', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('questionnaire_for_user.index');
    $trail->push('Form View', route('questionnaire_for_user.form.edit',$id));
});
Breadcrumbs::for('questionnaire.submitted.form1', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('ovm.questionnaire');
    $trail->push('Show', route('questionnaire_for_user.form.edit',$id));
});
Breadcrumbs::for('questionnaire.submitted.form2', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('sailquestionnairelistview');
    $trail->push('Show', route('questionnaire_for_user.form.edit',$id));
});
Breadcrumbs::for('recommendation.index', function (BreadcrumbTrail $trail) {
    $trail->push('Recommendation Report', route('recommendation.index'));
});
Breadcrumbs::for('recommendation.create', function ($trail) {
    $trail->parent('recommendation.index');
    $trail->push("Create", route('recommendation.create'));
});
Breadcrumbs::for('recommendation.edit', function ($trail,$id) {
    $trail->parent('recommendation.index');
    $trail->push("Edit", route('recommendation.edit',$id));
});
Breadcrumbs::for('recommendation.preview', function ($trail, $id) {
    $trail->parent('recommendation.index');
    $trail->push("Preview", route('recommendation.preview' , $id));
});

Breadcrumbs::for('compassobservation.index', function (BreadcrumbTrail $trail) {
    $trail->push('Observation', route('compassobservation.index'));
});
Breadcrumbs::for('Monthly', function ($trail) {
    $trail->parent('compassobservation.index');
    $trail->push("Monthly", route('monthlyindex'));
});

Breadcrumbs::for('monthlytab', function ($trail) {
    $trail->parent('compassobservation.index');
    $trail->push("MO", route('monthlytab'));
});

Breadcrumbs::for('referralreport.index', function (BreadcrumbTrail $trail) {
    $trail->push('Referral Report', route('referralreport.index'));
});
Breadcrumbs::for('referralreport.create', function ($trail) {
    $trail->parent('referralreport.index');
    $trail->push("Create", route('referralreport.create'));
});
Breadcrumbs::for('referralreport.edit', function ($trail,$id) {
    $trail->parent('referralreport.index');
    $trail->push("Edit", route('referralreport.edit',$id));
});
Breadcrumbs::for('referralreport.show', function ($trail,$id) {
    $trail->parent('referralreport.index');
    $trail->push("Preview", route('referralreport.show',$id));
});

Breadcrumbs::for('ovm_allocation.index', function (BreadcrumbTrail $trail) {
    $trail->push('OVM Allocation', route('ovm_allocation.index'));
});
Breadcrumbs::for('ovm_allocation.create', function ($trail) {
    $trail->parent('ovm_allocation.index');
    $trail->push("Initiation", route('ovm_allocation.create'));
});
Breadcrumbs::for('user_edit', function ($trail,$id) {
    $trail->push("OVM Allocation", route('user_edit',$id));
});
Breadcrumbs::for('ovm_allocation.edit', function ($trail,$id) {
    $trail->parent('ovm_allocation.index');
    $trail->push("Edit", route('ovm_allocation.edit',$id));
});
Breadcrumbs::for('inperson_meeting.index', function (BreadcrumbTrail $trail) {
    $trail->push('F2F', route('inperson_meeting.index'));
});
Breadcrumbs::for('inperson_meeting.show', function ($trail,$id) {
    $trail->parent('inperson_meeting.index');
    $trail->push("Show", route('inperson_meeting.show',$id));
});
Breadcrumbs::for('SentMeeting', function ($trail,$id) {
    $trail->parent('inperson_meeting.index');
    $trail->push("Edit", route('SentMeeting',$id));
});
Breadcrumbs::for('inperson_meeting.create', function (BreadcrumbTrail $trail) {
    $trail->parent('inperson_meeting.index');
    $trail->push('New Invite', route('inperson_meeting.create'));
});
Breadcrumbs::for('quadrant_questionnaire.index', function (BreadcrumbTrail $trail) {
    $trail->push('Questionnaire Report', route('quadrant_questionnaire.index'));
});
Breadcrumbs::for('quadrant_questionnaire.executive', function ($trail,$id) {
    $trail->parent('quadrant_questionnaire.index');
    $trail->push("Show", route('quadrant_questionnaire.executive',$id));
});
Breadcrumbs::for('quadrant_questionnaire.show', function ($trail,$id) {
    $trail->parent('quadrant_questionnaire.index');
    $trail->push("Show", route('quadrant_questionnaire.show',$id));
});
Breadcrumbs::for('userregisterfee.offline_payment', function ($trail,$id) {
    $trail->parent('userregisterfee.index');
    $trail->push("Complete Payment", route('userregisterfee.offline_payment',$id));
});
Breadcrumbs::for('coordinator.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Coordinator Allocation View', route('coordinator.list'));
});
Breadcrumbs::for('coordinator_allocation.index', function (BreadcrumbTrail $trail) {
    $trail->parent('coordinator.list');
    $trail->push('Coordinator Allocation', route('coordinator_allocation.index'));
});
Breadcrumbs::for('coordinator.show', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('coordinator.list');
    $trail->push('Show', route('coordinator.show',$id));
});
Breadcrumbs::for('g2form.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Parent Reflection Form', route('g2form.list'));
});
Breadcrumbs::for('g2form.new', function ($trail,$id) {
    $trail->parent('g2form.list');
    $trail->push($id, route('g2form.new',$id));
});
Breadcrumbs::for('thirteenyrsquestion_creation.index', function (BreadcrumbTrail $trail) {
    $trail->push('13+Question Creation', route('thirteenyrsquestion_creation.index'));
});
Breadcrumbs::for('thirteenyrsquestion_creation.create', function (BreadcrumbTrail $trail) {
    $trail->parent('thirteenyrsquestion_creation.index');
    $trail->push('Create', route('thirteenyrsquestion_creation.create'));
});
Breadcrumbs::for('thirteenyrsquestion_creation.show', function ($trail,$id) {
    $trail->parent('thirteenyrsquestion_creation.index');
    $trail->push("Show", route('thirteenyrsquestion_creation.show',$id));
});
Breadcrumbs::for('thirteenquestion_creation.add_questions', function ($trail,$id) {
    $trail->parent('thirteenyrsquestion_creation.index');
    $trail->push("Edit", route('thirteenquestion_creation.add_questions',$id));
});
Breadcrumbs::for('thirteenyrsquestionnaire_master.index', function (BreadcrumbTrail $trail) {
    $trail->push('13+Questionnaire Master', route('thirteenyrsquestionnaire_master.index'));
});
Breadcrumbs::for('thirteenyrsquestionnaire_master.create', function (BreadcrumbTrail $trail) {
    $trail->parent('thirteenyrsquestionnaire_master.index');
    $trail->push('Create', route('thirteenyrsquestionnaire_master.create'));
});
Breadcrumbs::for('thirteenyrsquestionnaire_master.edit', function ($trail,$id) {
    $trail->parent('thirteenyrsquestionnaire_master.index');
    $trail->push("Edit", route('thirteenyrsquestionnaire_master.edit',$id));
});
Breadcrumbs::for('questionnaire_allocation13.index', function (BreadcrumbTrail $trail) {
    $trail->push('13+Questionnaire Allocation', route('questionnaire_allocation13.index'));
});
Breadcrumbs::for('questionnaire_allocation13.create', function (BreadcrumbTrail $trail) {
    $trail->parent('questionnaire_allocation13.index');
    $trail->push('Allocate', route('questionnaire_allocation13.create'));
});
Breadcrumbs::for('questionnaire_allocation13.edit', function ($trail,$id) {
    $trail->parent('questionnaire_allocation13.index');
    $trail->push("Edit", route('questionnaire_allocation13.edit',$id));
});
Breadcrumbs::for('activity_allocation13.index', function (BreadcrumbTrail $trail) {
    $trail->push('Activity List 13+', route('activity_allocation13.index'));    
});
Breadcrumbs::for('activity_allocation13.create', function (BreadcrumbTrail $trail) {
    $trail->parent('activity_allocation13.index');
    $trail->push('Activity Initiate', route('activity_allocation13.create'));
});

Breadcrumbs::for('child_video_upload.childindex', function (BreadcrumbTrail $trail) {
    $trail->push('Activity List', route('child_video_upload.childindex'));
});
Breadcrumbs::for('child_video_upload.child_create', function (BreadcrumbTrail $trail,$id) {
    $trail->parent('child_video_upload.childindex');
    $trail->push('Video Upload', route('child_video_upload.child_create',$id));
});   
Breadcrumbs::for('payment_master.index', function (BreadcrumbTrail $trail) {
    $trail->push('Payment Master', route('payment_master.index'));
});
Breadcrumbs::for('payment_master.create', function (BreadcrumbTrail $trail) {
    $trail->parent('payment_master.index');
    $trail->push('Create', route('payment_master.create'));
});