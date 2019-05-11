<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('main', ['user' => Auth::user()]);
    });
});

Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
Route::post('/login', 'AuthController@postLogin');
Route::get('/logout', 'AuthController@logout');
Route::post('/telegram/web/hook/' . env('BOT_WEB_HOOK_HASH'), 'TelegramHookController@handle');

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::get('/whoami', function () {
        return Auth::user();
    });
    Route::post('user/password/{user}', 'UserController@changePassword');
    Route::apiResource('user', 'UserController');
    Route::apiResource('staff', 'StaffController');
    Route::apiResource('equipment/barcode', 'EquipmentBarcodeController');
    Route::apiResource('equipment', 'EquipmentController');
    Route::apiResource('group', 'GroupController');
    Route::apiResource('loan', 'LoanController');
    Route::apiResource('telegram-channel', 'TelegramChannelController');
    Route::apiResource('telegram-message', 'TelegramMessageController');
    Route::post('telegram-message/send-now/{telegramMessage}', 'TelegramMessageController@sendNow');
    Route::apiResource('student', 'StudentController', ['only' => ['store', 'destroy']]);
    Route::post('student/upload', 'StudentController@upload');
    Route::apiResource('raise_equipment', 'RaiseEquipmentController');
    Route::get('raise_equipment/change_status/{raiseEquipment}/{status}', 'RaiseEquipmentController@changeStatus');
    Route::post('loan/return', 'LoanController@returnLoan');
    Route::get('barcode', 'BarcodeController@getBarcode');
    Route::get('export/{model}/{type}', 'ImportExportController@export')
        ->where(['model' => '[a-z]+', 'type' => '(csv|xls|xlsx)']);
    Route::get('template/{model}/{type}', 'ImportExportController@exportTemplate')
        ->where(['model' => '[a-z]+', 'type' => '(csv|xls|xlsx)']);
    Route::post('import/{model}', 'ImportExportController@import')
        ->where(['model' => '[a-z]+']);
});
