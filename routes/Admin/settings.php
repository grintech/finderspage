<?php 
Route::get('/settings', '\App\Http\Controllers\Admin\SettingsController@index')
    ->name('admin.settings');

Route::post('/settings', '\App\Http\Controllers\Admin\SettingsController@index')
    ->name('admin.settings');

Route::post('/settings/email', '\App\Http\Controllers\Admin\SettingsController@email')
    ->name('admin.settings.email');

Route::post('/settings/social', '\App\Http\Controllers\Admin\SettingsController@social')
    ->name('admin.settings.social');

Route::post('/settings/recaptcha', '\App\Http\Controllers\Admin\SettingsController@recaptcha')
    ->name('admin.settings.recaptcha');

Route::post('/settings/date-time-formats', '\App\Http\Controllers\Admin\SettingsController@dateTimeFormats')
    ->name('admin.settings.dateTimeFormats');

Route::get('/settings/footer-links', '\App\Http\Controllers\Admin\SettingsController@footerLinks')
    ->name('admin.settings.footerLinks');
    
Route::post('/settings/footer-links', '\App\Http\Controllers\Admin\SettingsController@footerLinks')
    ->name('admin.settings.footerLinks');

Route::get('/settings/about-us', '\App\Http\Controllers\Admin\SettingsController@aboutus')
    ->name('admin.settings.aboutus');

Route::post('/settings/about-us', '\App\Http\Controllers\Admin\SettingsController@aboutus')
    ->name('admin.settings.aboutus');

Route::get('/settings/about-brenda', '\App\Http\Controllers\Admin\SettingsController@about_brenda')
    ->name('admin.settings.about.brenda');

Route::post('/settings/about-brenda','\App\Http\Controllers\Admin\SettingsController@about_brenda')
    ->name('admin.settings.about.brenda');