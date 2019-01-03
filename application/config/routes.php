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
$route['signup_mentor'] = 'user/signup_guru';
$route['signup_mentee'] = 'user/signup_applicant';
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['signup'] = 'welcome/confirm_signup';

$route['dashboard'] = 'user/dashboard';
$route['dashboard/(:any)'] = 'user/dashboard/$1';

$route['calendar'] = 'user/calendar';
$route['privacy-policy'] = 'user/privacy_policy';
$route['terms-conditions'] = 'user/terms_conditions';
$route['mentors'] = 'user/gurus';
$route['mentee'] = 'user/gurus';
$route['messages'] = 'user/messages';
$route['conversations'] = 'user/conversations';

$route['list-view'] = 'user/list_view';
$route['list-view/(:any)'] = 'user/list_view/$1';
$route['list-view/(:any)/(:num)'] = 'user/list_view/$1/$1';
$route['search-mentor'] = 'welcome/search_guru';
$route['search-mentor/(:any)'] = 'welcome/search_guru/$1';
$route['search-guru-university'] = 'welcome/search_guru_by_university';
$route['view-guru/(:any)'] = 'user/gurus_detail/$1';
$route['view-user/(:any)'] = 'user/gurus_detail/$1';
$route['approve-user/(:any)'] = 'user/approve_event/$1';
$route['cancel-event/(:any)'] = 'user/cancel_event/$1';
$route['mentor-profile/(:any)'] = 'user/gurus_detail/$1';
$route['mentee-profile/(:any)'] = 'user/gurus_detail/$1';
$route['schedule_timings'] = 'user/schedule_timings';
$route['user/schedule_mentor/(:any)'] = 'user/schedule_guru';
$route['account'] = 'user/account';
$route['404_override'] = 'welcome/page_404';
$route['faq'] = 'user/faq';
$route['translate_uri_dashes'] = FALSE;

/* Blog URLS */

$route['index'] = 'blog/home';
$route['blog'] = 'blog/home';
$route['blog/home/(:any)'] = 'blog/home';
$route['blog/login'] = 'blog/auth/login';
$route['auth/login_post'] = 'blog/auth/login_post';
$route['gallery'] = 'blog/home/gallery';
$route['contact'] = 'blog/home/contact';
$route['blog/post/(:any)'] = 'blog/home/post/$1';
$route['post/(:any)'] = 'blog/home/post/$1';
$route['category/(:any)'] = 'blog/home/category/$1';
$route['admin'] = 'blog/admin';

$route['admin/comments'] = 'blog/admin/comments';
$route['admin/menu_limit_post'] = 'blog/admin/menu_limit_post';
$route['admin/add_menu_link_post'] = 'blog/admin/add_menu_link_post';
$route['admin/delete_navigation_post'] = 'blog/admin/delete_navigation_post';
$route['admin/delete_page_post'] = 'blog/admin/delete_page_post';

$route['admin_post/add_post'] = 'blog/admin_post/add_post';
$route['admin_post/add_post_post'] = 'blog/admin_post/add_post_post';
$route['admin_post/update_post'] = 'blog/admin_post/update_post';
$route['admin_post/update_post_post'] = 'blog/admin_post/update_post_post';


$route['admin_post/posts'] = 'blog/admin_post/posts';
$route['admin_post/pending_posts'] = 'blog/admin_post/pending_posts';
$route['admin_post/post_options_post'] = 'blog/admin_post/post_options_post';

$route['reading-list'] = 'blog/home/reading_list';
$route['home/add_delete_from_reading_list_post'] = 'blog/home/add_delete_from_reading_list_post';

$route['admin/layout_options'] = 'blog/admin/layout_options';
$route['admin/layout_options_post'] = 'blog/admin/layout_options_post';

$route['admin/settings'] = 'blog/admin/settings';
$route['admin/settings_post'] = 'blog/admin/settings_post';

$route['admin/navigation'] = 'blog/admin/navigation';
$route['admin_category/update_category'] = 'blog/admin_category/update_category';
$route['admin_category/update_category_post'] = 'blog/admin_category/update_category_post';

$route['admin_post/post_slider_order_post'] = 'blog/admin_post/post_slider_order_post';

$route['admin_category/categories'] = 'blog/admin_category/categories';
$route['admin_category/add_category_post'] = 'blog/admin_category/add_category_post';
$route['admin_category/delete_category_post'] = 'blog/admin_category/delete_category_post';



$route['admin_category/subcategories'] = 'blog/admin_category/subcategories';
$route['admin_category/subcategories_post'] = 'blog/admin_category/subcategories_post';
$route['admin_category/get_sub_categories'] = 'blog/admin_category/get_sub_categories';


$route['admin_post/upload_ckimage_post'] = 'blog/admin_post/upload_ckimage_post';
$route['admin/users'] = 'blog/admin/users';
$route['admin/update_page_post'] = 'blog/admin/update_page_post';

$route['admin/update_page/(:any)'] = 'blog/admin/update_page/$1';
$route['search'] = 'blog/home/search';
$route['home/add_comment_post'] = 'blog/home/add_comment_post';
$route['home/delete_comment_post'] = 'blog/home/delete_comment_post';
$route['admin/delete_comment_post'] = 'blog/admin/delete_comment_post';













