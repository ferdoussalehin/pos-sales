<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['create_supplier'] = "supplier/supplier/create_supplier";
$route['edit_supplier/(:num)'] = "supplier/supplier/edit_supplier/$1";
$route['suppliers'] = "supplier/supplier/index";

$route['billers'] = "supplier/biller/index";
$route['create_biller'] = "supplier/biller/create_biller";
$route['edit_biller/(:num)'] = "supplier/biller/edit_biller/$1";
