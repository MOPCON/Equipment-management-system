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

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('user', 'UserController');
    Route::resource('staff', 'StaffController');
    Route::resource('equipment/barcode', 'EquipmentBarcodeController');
    Route::resource('equipment', 'EquipmentController');
    Route::resource('group', 'GroupController');
    Route::resource('loan', 'LoanController');
    Route::post('loan/return', 'LoanController@returnLoan');
    Route::get('barcode', 'BarcodeController@getBarcode');
});
