<?php

if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = 'AED')
    {
        return $currency . ' ' . number_format($amount, 2);
    }
}


if (!function_exists('set_active_route')) {
    function set_active_route($routeName, $activeClass = 'active')
    {
        return request()->routeIs($routeName) ? $activeClass : '';
    }
}
