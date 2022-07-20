<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('product_name')) {
    function product_name($name, $size = 0)
    {
        if (!$size) {
            $size = 42;
        }
        return character_limiter($name, ($size - 5));
    }
}