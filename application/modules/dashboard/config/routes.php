<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['dashboard']     = "dashboard/dashboard";
$route['language'] = "dashboard/language";
$route['create_user'] = "dashboard/user/create_user_form";
$route['edit_user/(:num)'] = "dashboard/user/edit_user_form/$1";
$route['users'] = "dashboard/user/users";
$route['user/view/(:num)'] = "dashboard/user/view/$1";
