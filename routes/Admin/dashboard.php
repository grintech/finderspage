<?php
Route::get('/dashboard', '\App\Http\Controllers\Admin\DashboardController@index')
    ->name('admin.dashboard');
Route::get('/check', '\App\Http\Controllers\Admin\DashboardController@getall');