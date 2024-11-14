<?php
Route::get('/newsletter', '\App\Http\Controllers\Admin\NewsLettersController@index')
    ->name('admin.newsletter');

Route::get('/newsletter/export', '\App\Http\Controllers\Admin\NewsLettersController@export')
    ->name('admin.newsletter.export');

Route::match(['get', 'post'], '/newsletter/add', '\App\Http\Controllers\Admin\NewsLettersController@add')
    ->name('admin.newsletter.add');


Route::match(['get', 'post'], '/newsletter/{id}/edit', '\App\Http\Controllers\Admin\NewsLettersController@edit')
    ->name('admin.newsletter.edit');

Route::post('/newsletter/bulkActions/{action}', '\App\Http\Controllers\Admin\NewsLettersController@bulkActions')
    ->name('admin.newsletter.bulkActions');

Route::get('/newsletter/{id}/delete', '\App\Http\Controllers\Admin\NewsLettersController@delete')
    ->name('admin.newsletter.delete');


Route::post('/newsletter/email', '\App\Http\Controllers\Admin\NewsLettersController@SendBulkEmail')
    ->name('admin.newsletter.email');

