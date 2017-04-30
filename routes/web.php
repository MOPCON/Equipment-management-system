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



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('adminlte::home');
    });

    Route::get('/staffs', function () {
        return view('adminlte::staffs.index');
    });

    Route::get('/groups', function () {
        return view('adminlte::groups.index');
    });

    Route::get('/equipments', function () {
        return view('adminlte::equipment.index');
    });
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
