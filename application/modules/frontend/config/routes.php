<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['create_customer'] = "customer/customer/create_customer";
$route['edit_customer/(:num)'] = "customer/customer/edit_customer/$1";
$route['customers'] = "customer/customer/index";