<?php
Route::match(['get', 'post'], '/home-settings', '\App\Http\Controllers\Admin\HomeSettingsController@index')
    ->name('admin.homeSettings');

Route::match(['get', 'post'], '/home-section2', '\App\Http\Controllers\Admin\HomeSettingsController@section2')
    ->name('admin.homeSettings.section2');

Route::match(['get', 'post'], '/home-section3', '\App\Http\Controllers\Admin\HomeSettingsController@section3')
    ->name('admin.homeSettings.section3');

// About
Route::match(['get', 'post'], '/home-about', '\App\Http\Controllers\Admin\HomeSettingsController@about')
    ->name('admin.homeSettings.about');

Route::match(['get', 'post'], '/home-about1', '\App\Http\Controllers\Admin\HomeSettingsController@about1')
    ->name('admin.homeSettings.about1');

Route::match(['get', 'post'], '/home-about2', '\App\Http\Controllers\Admin\HomeSettingsController@about2')
    ->name('admin.homeSettings.about2');

Route::match(['get', 'post'], '/home-about3', '\App\Http\Controllers\Admin\HomeSettingsController@about3')
    ->name('admin.homeSettings.about3');

Route::match(['get', 'post'], '/home-certification', '\App\Http\Controllers\Admin\HomeSettingsController@certification')
    ->name('admin.homeSettings.certification');