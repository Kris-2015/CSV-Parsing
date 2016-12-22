<?php

/*
|--------------------------------------------------------------------------
| Custom Validator File
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| @author: msfi-krishnadev
| @date: 17th October, 2016
*/

// Custom Validation for field which may contains spaces and numeric
Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[a-zA-Z0-9,\s]*$/', $value);
});