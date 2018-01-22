<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['guru'] = 'user/signup_guru';
$route['user'] = 'user/signup_applicant';
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['signup'] = 'welcome/confirm_signup';

$route['dashboard'] = 'user/dashboard';
$route['dashboard/(:any)'] = 'user/dashboard/$1';

$route['calendar'] = 'user/calendar';
$route['privacy-policy'] = 'user/privacy_policy';
$route['terms-conditions'] = 'user/terms_conditions';
$route['mentors'] = 'user/gurus';
$route['applicants'] = 'user/gurus';
$route['messages'] = 'user/messages';
$route['conversations'] = 'user/conversations';

$route['list-view'] = 'user/list_view';
$route['list-view/(:any)'] = 'user/list_view/$1';
$route['list-view/(:any)/(:num)'] = 'user/list_view/$1/$1';
$route['search-guru'] = 'welcome/search_guru';
$route['search-guru/(:any)'] = 'welcome/search_guru/$1';
$route['search-guru-university'] = 'welcome/search_guru_by_university';
$route['view-guru/(:any)'] = 'user/gurus_detail/$1';
$route['view-user/(:any)'] = 'user/gurus_detail/$1';
$route['approve-user/(:any)'] = 'user/approve_event/$1';
$route['cancel-event/(:any)'] = 'user/cancel_event/$1';
$route['guru-profile/(:any)'] = 'welcome/gurus_detail/$1';
$route['gurus-profile/(:any)'] = 'user/gurus_detail/$1';
$route['applicants-profile/(:any)'] = 'user/gurus_detail/$1';
$route['404_override'] = 'welcome/page_404';
$route['translate_uri_dashes'] = FALSE;
