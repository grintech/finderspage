<?php
Route::get('/slider', '\App\Http\Controllers\Admin\SliderController@index')
    ->name('admin.slider');

Route::get('/slider/add', '\App\Http\Controllers\Admin\SliderController@add')
    ->name('admin.slider.add');

Route::post('/slider/add', '\App\Http\Controllers\Admin\SliderController@add')
    ->name('admin.slider.add');

Route::get('/slider/{id}/view', '\App\Http\Controllers\Admin\SliderController@view')
    ->name('admin.slider.view');

Route::get('/slider/{id}/edit', '\App\Http\Controllers\Admin\SliderController@edit')
    ->name('admin.slider.edit');

Route::post('/slider/{id}/edit', '\App\Http\Controllers\Admin\SliderController@edit')
    ->name('admin.slider.edit');

Route::post('/slider/bulkActions/{action}', '\App\Http\Controllers\Admin\SliderController@bulkActions')
    ->name('admin.slider.bulkActions');

Route::get('/slider/{id}/delete', '\App\Http\Controllers\Admin\SliderController@delete')
    ->name('admin.slider.delete');