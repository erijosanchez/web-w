<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $class = 'active') {
        return Route::currentRouteName() === $routeName ? $class : '';
    }
}
