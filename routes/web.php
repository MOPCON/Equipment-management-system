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


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function() {
        return view('adminlte::home');
    });

    Route::get('/staffs', function() {
        return view('adminlte::staffs.index');
    });

    Route::get('/groups', function() {
        return view('adminlte::groups.index');
    });

    Route::get('/equipments', function() {
        return view('adminlte::equipment.index');
    });

    Route::get('/equipments/barcode', function() {
        return view('adminlte::equipment.barcode');
    });

    Route::get('/loan', function() {
        return view('adminlte::loan.index');
    });

    Route::get('/loan/action', function() {
        return view('adminlte::loan.action');
    });

    Route::get('/tool/print', function() {
        return view('adminlte::tool.print');
    });
});
