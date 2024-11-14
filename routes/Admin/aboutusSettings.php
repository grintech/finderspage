<?php
Route::match(['get', 'post'], '/aboutus-settings', '\App\Http\Controllers\Admin\AboutSettingsController@index')
    ->name('admin.aboutSettings');