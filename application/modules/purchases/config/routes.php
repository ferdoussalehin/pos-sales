
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['purchases'] = 'purchases/purchases/index';
$route['purchases/view'] = 'purchases/purchases/view';
$route['purchases/pdf_purchase/(:num)'] = 'purchases/purchases/pdf_purchase/$1';