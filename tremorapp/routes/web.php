<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Default path of web app
Route::get('/', function () {
    return view('home');
});

// Show get report login screen by token and hash key
Route::get('report', 'ReportController@report');

// Using api middleware for throttle functionality
Route::group(['middleware' => 'api'], function() {
    
    // validate the user
    Route::post('getReport', [
        'as' => 'getReport',
        'uses' => 'ReportController@validateUser'
    ]);

    // perform the download operation
    Route::post('downloadReport', [
        'as' => 'downloadReport',
        'uses' => 'ReportController@authenticateUser'
    ]);
});

// Submit the report id and uri of the report
Route::post('getReportComplete', [
    'as' => 'getReportComplete',
    'uses' => 'ReportController@getReportComplete'
]);