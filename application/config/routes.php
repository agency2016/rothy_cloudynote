<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['noteresult']                                = "noteresult/shownoteresult";
$route['user/setup_school']                         = "create_class/create_class_view"; //show pricing options
$route['user/setup_success']                        = "create_class/setup_school_success";
$route['user/setup_staff']                          = "create_class/add_staff"; //show pricing options
$route['user/setup_students']                       = "create_class/add_students";
$route['user/setup_profile']                        = 'user_manager/organisation_setup';

$route['default_controller']                        = "home";
$route['404_override']                              = "home/error_not_found";

//Custom routing
$route['pricing']                                   = "payment/pricing"; //show pricing options
$route['contact-us']                                = "home/contact"; //show contact page
$route['about-us']                                  = "home/about"; //show contact page
$route['privacy-policy']                            = "home/privacy"; //show contact page
$route['feature']                                   = "home/feature"; //show the feature list
$route['about-us']                                  = "home/about"; //show about us page
$route['how-it-work']                               = "home/howItWork"; //show howItWork page
$route['privacy-policy']                            = "home/privacy"; //show privacy-policy page
$route['term-of-service']                           = "home/termOfService"; //show term-of-service page
$route['faq']                                       = "home/faq"; //show term-of-service page
$route['refer-a-friend']                            = "home/refer_a_friend"; //refer cloudenotes to a friend page
$route['save-paper']                                = "home/save_paper"; //refer cloudenotes to a friend page

//Authentication Routing
$route['register']                                  = "auth/register"; //do register
$route['login']                                     = "auth/login"; //do login
$route['logout']                                    = "auth/logout"; //do logout
$route['success']                                   = "auth/success"; //show success page after registration
$route['error']                                     = "auth/error"; //show error message for any purpose
$route['activation']                                = "auth/activate";
$route['activation/(:any)']                         = "auth/activate"; //activate registered account
$route['org-(:num)/in/(:any)/acpt-invt/con-(:any)'] = "auth/accept_invite_user/$1/$2/$3"; //accept invitation url
$route['org-(:num)/in/(:any)/dn-invt/con-(:any)']   = "auth/deny_invite_user"; //deny invitation url
$route['forgot-password']                           = "auth/forgot_password"; //request for password


//Admin Section
$route['dashboard/user']                            = 'dashboard/index'; //dashboard for super admin. see first user list page
$route['dashboard/user/page']                       = 'dashboard/index'; //user list with pagination
$route['dashboard/user/page/(:num)']                = 'dashboard/index'; //user list with pagination
$route['dashboard/user/edit/(:num)']                = 'dashboard/edit_user_profile/$1'; //edit any user info with user id
$route['dashboard/user/view/(:num)']                = 'dashboard/vew_user_info/$1'; //view any user info with user id
$route['dashboard/user/remove/(:num)']              = 'dashboard/remove_user/$1'; //remove any user
$route['dashboard/activity']                        = 'dashboard/activity_log'; //Activity Log for Admin
$route['dashboard/activity/(:num)']                 = 'dashboard/activity_log/$1'; //Activity Log for Admin pagination
$route['dashboard/settings']                        = 'dashboard/settings'; //dashboard settings


//Note Section
$route['notes']                                     = 'notes/index'; //see all notes
$route['notes/page']                                = 'notes/view_note_list'; //see all notes
$route['notes/page/(:num)']                         = 'notes/view_note_list'; //see all notes with pagination
$route['notes/new']                                 = 'notes/new_note'; //create new note
$route['notes/edit/(:num)']                         = 'notes/new_note';//edit note
//$route['notes/edit/(:num)']                         = 'notes/edit_note/$1';
//'notes/note_public_view/(:child_id)/(:md5(note_id+child_id+parent_email))/(encoded_parent_email)'
$route['note/reply/public/(:any)/(:any)/(:any)']    = 'notes/note_public_reply_view/$1/$2/$3';
$route['note/public-view/(:any)']                   = 'notes/note_public_view/$1';
$route['note/reply/(:any)']                         = 'notes/replies/$1';
$route['note/note-result/(:num)']                   = "notes/view_note_result";
$route['note/note-consent/(:num)']                  = "notes/view_note_consent";
$route['note/note-non-consent/(:num)']              = "notes/view_note_non_consent";
$route['note/note-not-replied/(:num)']              = "notes/view_note_not_replied";
$route['note/post-ajax-del-note']                   = "notes/post_ajax_del_note";


$route['user']                                      = 'user_manager/index';
$route['user/profile']                              = 'user_manager/profile';
$route['user/edit-profile']                         = 'user_manager/edit_profile';
$route['user/setup_profile']                        = 'user_manager/organisation_setup';
$route['user/org_image_upload']                            = 'user_manager/crop_image_for_org';

//$route['user/sections']                           = 'user_manager/invite_user';
$route['user/classes']                              = 'user_manager/sections';
$route['user/classes/(:num)']                       = 'user_manager/sections';
$route['user/add-class']                            = 'user_manager/add_sections';
$route['user/postAjaxList']                          = 'user_manager/get_Student_List_Within_Class_Via_Ajax';
$route['user/post-ajax-class-list']                 = 'user_manager/post_student_class_with_ajax';
$route['user/post-ajax-del-student']                = 'user_manager/post_delete_student_with_ajax';
$route['user/post-ajax-del-class']                  = 'user_manager/post_delete_class_with_ajax';
$route['user/upload-image']                         = 'user_manager/post_ajax_upload_profile_image';
$route['user/post-ajax-parent-invite']              = 'user_manager/post_ajax_parent_invite';
$route['user/post-ajax-staff-invite']               = 'user_manager/post_ajax_staff_invite';


//parents
$route['user/parent']                               = 'user_manager/parent_dashboard';
$route['user/parentPayment']                        = 'user_manager/parent_payment';
$route['user/parentProfile']                        = 'user_manager/parent_profile';
$route['user/post-ajax-save-child-profile']         = 'user_manager/post_ajax_save_child_profile';
$route['user/save-other-parent']                    = 'user_manager/post_ajax_save_other_parent_profile';
$route['user/save-parent']                          = 'user_manager/post_ajax_save_parent_profile';
$route['user/post-ajax-staff-class-list']           = 'user_manager/post_staff_class_with_ajax';

//$route['user/invite-authenticate-user'] = 'user_manager/invite_user';
//$route['user/invite-user'] = 'user_manager/invite_user';
$route['user/invite-teacher'] = 'user_manager/invite_user';
//$route['user/invite-section-leader'] = 'user_manager/invite_user';


//Authenticated list
//$route['user/authenticate-user-list'] = 'user_manager/assigned_user_list';
//$route['user/user-list'] = 'user_manager/assigned_user_list';

//$route['user/teacher-list'] = 'user_manager/assigned_user_list';
$route['user/staff-list']             = 'user_manager/assigned_user_list';
$route['user/add-staff']              = 'user_manager/add_staff';
$route['user/post-ajax-del-staff']    = 'user_manager/post_ajax_del_staff';
$route['user/editStaff/(:any)']       = 'user_manager/editStaff';
$route['user/post-ajax-update-staff'] = 'user_manager/post_ajax_update_staff';
$route['user/post-ajax-staff-invite'] = 'user_manager/post_ajax_staff_invite';


//routing for student access
$route['user/add-students']       = 'user_manager/add_section_member';
$route['user/editStudent/(:any)'] = 'user_manager/editStudent';
$route['user/students']           = 'user_manager/sections_member';
$route['user/students/(:num)']    = 'user_manager/sections_member';
$route['user/students/(:any)']    = 'user_manager/view_single_student';
$route['user/activity']           = 'activity_log/index';
$route['user/institute-view']     = 'user_manager/admin_dashboard_ins_registration';
$route['user/parent-student-view']= 'user_manager/admin_dashboard_parent_student_registration';
//$route['user/postAjaxEditStudent'] = 'user_manager/postAjaxEditStudent';


//payment route for admin user
$route['payment']             = 'payment/index';
$route['payment/plan']        = 'payment/index';
$route['payment/plan/(:any)'] = 'payment/index/$1';
$route['payment/log']         = 'payment/payment_activity_log';
$route['payment/log/(:num)']  = 'payment/payment_activity_log/$1';

//event view
$route['user/calendar']      = 'user_manager/view_calendar';
$route['user/calendar-data'] = 'user_manager/calendar_data';


//New View Sample routing
//Dashboard view needs to be changed
//student view

$route['view']              = 'home/student_view';
$route['activity']          = 'home/activity_log';
$route['email_template']    = 'home/view_email_template';
$route['ps-registrations']  = 'home/parent_student_registrations';
$route['ins-registrations'] = 'home/institute_registrations';
$route['class-view']        = 'home/class_view';
$route['parent']            = 'home/parent_dashboard';

$route['view']              = 'home/student_view';
$route['activity']          = 'home/activity_log';
$route['email_template']    = 'home/view_email_template';
$route['ps-registrations']  = 'home/parent_student_registrations';
$route['ins-registrations'] = 'home/institute_registrations';
$route['class-view']        = 'home/class_view';
$route['admin-dashboard']   = 'home/admin_dashboard';

/*V-2 View*/
$route['student-list']      = 'home/school_admin_student_list';
$route['class-list']        = 'home/school_admin_class_list';
$route['staff-list']        = 'home/school_admin_staff_list';
$route['staff-list/(:num)'] = 'home/school_admin_staff_list/$1';


//
$route['user/settings']    = 'user_manager/user_settings';
$route['user/permissions'] = 'user_manager/user_permissions';


$route['admin/settings']    = 'user_manager/admin_user_settings';
$route['admin/permissions'] = 'user_manager/admin_user_permissions';

/* End of file routes.php */
/* Location: ./application/config/routes.php */