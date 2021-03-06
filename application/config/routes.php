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
$route_path = APPPATH . 'routes/';
// require_once $route_path . 'routes_landing.php';
$route['projects/(:num)'] = 'projects/index/$1';
$route['thankyou'] = 'pages/thankyou';
$route['calc'] = 'pages/calculator';
$route['contact'] = 'pages/contact';
$route['contact_submit'] = 'pages/contact_submit';
$route['register'] = 'pages/register';
$route['login'] = 'pages/login';
$route['forgot-password'] = 'pages/forgot_password';
$route['register_submit'] = 'pages/register_submit';
$route['authentication'] = 'pages/authentication';
$route['verify_email/(:any)/(:any)/(:any)'] = 'pages/verify_email/$1/$2/$3';
$route['forgot_password_submit'] = 'pages/forgot_password_submit';
$route['new_password/(:any)/(:any)/(:any)'] = 'pages/new_password/$1/$2/$3';
$route['new_password_submit'] = 'pages/new_password_submit';

$route['products/(:num)'] = 'products/index/$1';

$route['about'] = 'pages/about';
$route['vision_mission'] = 'pages/vision_mission';
$route['distributor'] = 'pages/distributor';
$route['default_controller'] = 'pages/index';

$route['404_override'] = 'pages/not_found';
$route['translate_uri_dashes'] = FALSE;

$route['administrator/login'] = 'administrator/auth/login';
$route['administrator/register'] = 'administrator/auth/register';
$route['administrator/forgot-password'] = 'administrator/auth/forgot_password';

$route['page/(:num)/(:any)'] = 'pages/page_details/$1/$2';
$route['administrator/web-page'] = 'administrator/page/admin';
