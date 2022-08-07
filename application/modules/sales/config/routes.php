<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['pos/add'] = "sales/pos/index";
$route['sales/add'] = "sales/sale/add";
$route['pos/sales'] = "sales/pos/sales";
$route['sales'] = "sales/sale";
$route['sales/return_sale_form'] = "sales/sale/return_sale_form";
$route['sales/return_sale_barcode/(:num)'] = "sales/sale/return_sale_barcode/$1";
// $route['pos/view_receipt/(:num)'] = "sales/pos/view_receipt/$1";
$route['pos/view/(:num)'] = "sales/pos/view/$1";
$route['sales/view/(:num)'] = "sales/sale/view/$1";
$route['sales/view_payments/(:num)'] = "sales/sale/view_payments/$1";
$route['pos/view_receipt/(:num)'] = "sales/pos/view_receipt/$1";
$route['pos/delete/(:num)'] = "sales/pos/delete/$1";
$route['sales/delete_payment/(:num)'] = "sales/sale/delete_payment/$1";
$route['pos/edit/(:num)'] = "sales/pos/edit/$1";

$route['sales/edit/(:num)'] = "sales/sale/edit/$1";
$route['sales/return_sale/(:num)'] = "sales/sale/return_sale/$1";

$route['sales/payments/(:num)'] = "sales/sale/payments/$1";
$route['pos/savePayment/(:num)'] = "sales/pos/savePayment/$1";
$route['sale/savePayment/(:num)'] = "sales/sale/savePayment/$1";
$route['sales/delete/(:num)'] = "sales/sale/delete/$1";

