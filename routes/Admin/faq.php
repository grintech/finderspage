<?php
Route::get('/faq', '\App\Http\Controllers\Admin\FaqController@index')
    ->name('admin.faq');

Route::match(['get', 'post'], '/faq/add', '\App\Http\Controllers\Admin\FaqController@add')
    ->name('admin.faq.add');

Route::get('/faq/{id}/view', '\App\Http\Controllers\Admin\FaqController@view')
    ->name('admin.faq.view');

Route::match(['get', 'post'], '/faq/{id}/edit', '\App\Http\Controllers\Admin\FaqController@edit')
    ->name('admin.faq.edit');

Route::post('/faq/bulkActions/{action}', '\App\Http\Controllers\Admin\FaqController@bulkActions')
    ->name('admin.faq.bulkActions');

Route::get('/faq/{id}/delete', '\App\Http\Controllers\Admin\FaqController@delete')
    ->name('admin.faq.delete');