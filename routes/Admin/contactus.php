<?php
Route::get('/contactus', '\App\Http\Controllers\Admin\ContactUsController@index')
    ->name('admin.contactus');

Route::match(['get', 'post'], '/contactus/add', '\App\Http\Controllers\Admin\ContactUsController@add')
    ->name('admin.contactus.add');

Route::get('/contactus/{id}/view', '\App\Http\Controllers\Admin\ContactUsController@view')
    ->name('admin.contactus.view');

Route::match(['get', 'post'], '/contactus/{id}/edit', '\App\Http\Controllers\Admin\ContactUsController@edit')
    ->name('admin.contactus.edit');

Route::post('/contactus/bulkActions/{action}', '\App\Http\Controllers\Admin\ContactUsController@bulkActions')
    ->name('admin.contactus.bulkActions');

Route::get('/contactus/{id}/delete', '\App\Http\Controllers\Admin\ContactUsController@delete')
    ->name('admin.contactus.delete');