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
$route['search'] = 'welcome/search';
$route['search/school/details/(.*)'] = 'welcome/searchDetailsSchool/$1';
$route['search/student/details/(.*)'] = 'welcome/searchDetailsStudent/$1';
//login
$route['dashboard/login'] = 'admin/login';
$route['login/loginAction'] = 'admin/login/loginAction';
$route['dashboard/logout'] = 'admin/login/logoutAction';


//main dashboard
$route['dashboard'] = 'admin/home';
//$route['dashboard/upload'] = 'admin/upload';
//$route['upload/do_upload'] = 'admin/upload/do_upload';

//Secondary school admin uploads student details
$route['dashboard/students'] = 'admin/students';
$route['dashboard/students/list'] = 'admin/students/listStudents';
$route['dashboard/students/result/(.*)'] = 'admin/students/studentResult/$1';
$route['students/do_upload'] = 'admin/students/do_upload';

//University uploads course details
$route['dashboard/courses'] = 'admin/courses';
$route['courses/do_upload'] = 'admin/courses/do_upload';

//UNEB upload results
$route['dashboard/upload'] = 'admin/upload';
$route['upload/do_upload'] = 'admin/upload/do_upload';
$route['dashboard/subjects'] = 'admin/subject';
$route['dashboard/subjects/do_upload'] = 'admin/subject/do_upload';
$route['upload/do_upload'] = 'admin/upload/do_upload';

//UNEB export results
$route['dashboard/excel'] = 'admin/export';
$route['excel/index'] = 'admin/excel/index';

//view students results
$route['dashboard/students'] = 'admin/students';
$route['students/list'] = 'admin/students/list';

//Upload subjects
$route['dashboard/subject'] = 'admin/subject';
$route['subject/do_upload'] = 'admin/subject/do_upload';

//school
$route['dashboard/school'] = 'admin/school';
$route['dashboard/school/add'] = 'admin/school/add';
$route['dashboard/school/view'] = 'admin/school/list_school';
$route['dashboard/school/view/(:any)'] = 'admin/school/view/$1';
$route['dashboard/school/delete/(:num)'] = 'admin/school/delete/$1';
$route['dashboard/school/search_school'] = 'admin/school/search_school';
$route['dashboard/university'] = 'admin/university';
$route['dashboard/university/add'] = 'admin/university/add';
$route['dashboard/university/view'] = 'admin/university/list_university';
$route['dashboard/university/view/(:num)'] = 'admin/university/view/$1';
$route['dashboard/university/delete/(:num)'] = 'admin/university/delete/$1';


//users
$route['dashboard/user'] = 'admin/user';
$route['dashboard/user/add'] = 'admin/user/createUser';
$route['dashboard/user/view'] = 'admin/user/viewUser';
$route['dashboard/user/delete/(:num)'] = 'admin/user/deleteUser/$1';
//maps

$route['dashboard/maps'] = 'maps';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
