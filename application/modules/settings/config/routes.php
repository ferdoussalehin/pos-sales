<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['settings'] = "settings/settings/index";
$route['pos_settings'] = "settings/settings/pos_settings";

$route['settings/units'] = "settings/settings/units";
$route['settings/add_unit'] = "settings/settings/add_unit";
$route['settings/saveUnit'] = "settings/settings/saveUnit";
$route['edit_unit/(:num)'] = "settings/settings/edit_unit/$1";
$route['settings/editUnit'] = "settings/settings/editUnit";
$route['settings/delete_unit/(:num)'] = "settings/settings/delete_unit/$1";