<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Auth//
$route['login']['get']='Auth/index'; //view page login
$route['login']['post']='Auth/login'; //login logic 
$route['logout']='Auth/logout';//logout 
//2fa
$route['two-fa']='Auth/twofa';
$route['verify-fa']='Auth/verifyfa';
$route['resend-fa']='Auth/resendfa';
//Auth-Registraction
$route['register']='Auth/register'; //view page
$route['join']['post']='Auth/register'; //logic
$route['email-verify/(:any)']['get']='Auth/verify_view/$1';
$route['resend-email/(:any)']['get']='Auth/resendotp/$1';
$route['email-verify']['post']='Auth/verify_view';
//user
$route['dashboard']='user/Dashboard';
$route['ajaxusermaprate']='user/Dashboard/ajaxusermaprate';
$route['place-order']='user/Dashboard/placeorder';


$route['profile']='user/Profile';
$route['profile-update']='user/Profile/profile_update';
$route['profile-password-update']='user/Profile/password';




//Admin

$route['update-user']='user/Dashboard/updateemp';
$route['usersjson']='user/Dashboard/usersjson';
$route['manage-user']='user/Dashboard/listemp';
$route['ajaxadminsetrate']='user/Dashboard/ajaxadminsetrate';
$route['saverate']='user/Dashboard/saverate';
