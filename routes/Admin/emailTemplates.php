<?php
Route::get('/email-templates', '\App\Http\Controllers\Admin\EmailTemplatesController@index')
    ->name('admin.emailTemplates');



Route::get('/add-templates', '\App\Http\Controllers\Admin\EmailTemplatesController@addTemplate')
    ->name('add.admin.emailTemplates');

Route::get('/email-templates/{id}/edit', '\App\Http\Controllers\Admin\EmailTemplatesController@edit')
    ->name('admin.emailTemplates.edit');

Route::post('/email-templates/{id}/edit', '\App\Http\Controllers\Admin\EmailTemplatesController@edit')
    ->name('admin.emailTemplates.edit');


Route::post('/email-templates/save', '\App\Http\Controllers\Admin\EmailTemplatesController@SaveTemplate')
    ->name('admin.emailTemplates.save');