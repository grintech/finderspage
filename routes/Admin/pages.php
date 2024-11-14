<?php
Route::get('/pages', '\App\Http\Controllers\Admin\PagesController@index')
    ->name('admin.pages');

Route::get('/pages/{id}/view', '\App\Http\Controllers\Admin\PagesController@view')
    ->name('admin.pages.view');

Route::get('/pages/{id}/edit', '\App\Http\Controllers\Admin\PagesController@edit')
    ->name('admin.pages.edit');

Route::post('/pages/{id}/edit', '\App\Http\Controllers\Admin\PagesController@edit')
    ->name('admin.pages.edit');

Route::post('/pages/bulkActions/{action}', '\App\Http\Controllers\Admin\PagesController@bulkActions')
    ->name('admin.pages.bulkActions');