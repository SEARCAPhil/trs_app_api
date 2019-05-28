<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Authentication
 */
Route::post('/app', 'AppsController@auth');
Route::post('/account/session', 'Account\SessionController@auth');
Route::post('/auth/corporate', 'Auth\CorporateController@auth');

/**
 * Drivers
 */
Route::get('/account/driver', 'Account\DriverController@lists');


/**
 * Automobile
 */
Route::get('/automobile', 'AutomobileController@lists');
Route::post('/automobile', 'AutomobileController@createService');
Route::get('/automobile/{id}', 'AutomobileController@view');
Route::put('/automobile/{id}', 'AutomobileController@updateService');
Route::delete('/automobile/{id}', 'AutomobileController@delete');
Route::get('/automobile/search/{param}', 'AutomobileController@search');


/**
 * Automobile\TimeRecord
 */
Route::get('/automobile/records/time', 'Automobile\TimeRecordController@lists');
Route::post('/automobile/records/time', 'Automobile\TimeRecordController@createService');
Route::get('/automobile/records/time/{id}', 'Automobile\TimeRecordController@view');
Route::put('/automobile/records/time/{id}', 'Automobile\TimeRecordController@updateService');
Route::delete('/automobile/records/time/{id}', 'Automobile\TimeRecordController@delete');
Route::get('/automobile/records/time/search/{param}/{date}', 'Automobile\TimeRecordController@search');