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

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::resource('user', 'UserController');
    Route::resource('staff', 'StaffController');
    Route::resource('equipment/barcode', 'EquipmentBarcodeController');
    Route::resource('equipment', 'EquipmentController');
    Route::resource('group', 'GroupController');
    Route::resource('loan', 'LoanController');
    Route::post('loan/return', 'LoanController@returnLoan');
    Route::get('barcode', 'BarcodeController@getBarcode');
});