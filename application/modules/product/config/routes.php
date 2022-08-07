<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['products'] = "product/product/index";
$route['create_product'] = "product/product/create_product";
$route['edit_product/(:num)'] = "product/product/edit_product/$1";
$route['view_product/(:num)'] = "product/product/view_product/$1";