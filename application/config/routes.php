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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'Dashboard/index';
$route['lini'] = 'Lini/index';
$route['login'] = 'Login/index';
$route['login/process_login'] = 'login/process_login';   

$route['lini/add'] = 'lini/add';
$route['lini/edit/(:num)'] = 'lini/edit/$1';
$route['lini/update'] = 'lini/update';
$route['lini/delete/(:num)'] = 'lini/delete/$1';

$route['area'] = 'Area/index';
$route['area/add'] = 'Area/add';
$route['area/edit/(:num)'] = 'Area/edit/$1';
$route['area/update'] = 'Area/update';
$route['area/delete/(:num)'] = 'Area/delete/$1';

$route['mesin'] = 'Mesin/index';
$route['mesin/add'] = 'Mesin/add';
$route['mesin/edit/(:num)'] = 'Mesin/edit/$1';
$route['mesin/update'] = 'Mesin/update';
$route['mesin/delete/(:num)'] = 'Mesin/delete/$1';

$route['manpower'] = 'Manpower/index';
$route['manpower/add'] = 'Manpower/add';
$route['manpower/edit/(:num)'] = 'Manpower/edit/$1';
$route['manpower/update'] = 'Manpower/update';
$route['manpower/delete/(:num)'] = 'Manpower/delete/$1';

$route['departemen'] = 'Departemen/index';
$route['departemen/add'] = 'Departemen/add';
$route['departemen/edit/(:num)'] = 'Departemen/edit/$1';
$route['departemen/update'] = 'Departemen/update';
$route['departemen/delete/(:num)'] = 'Departemen/delete/$1';

