<?php
Route::get('/testimonials', '\App\Http\Controllers\Admin\TestimonialsController@index')
    ->name('admin.testimonials');

Route::match(['get', 'post'], '/testimonials/add', '\App\Http\Controllers\Admin\TestimonialsController@add')
    ->name('admin.testimonials.add');

Route::get('/testimonials/{id}/view', '\App\Http\Controllers\Admin\TestimonialsController@view')
    ->name('admin.testimonials.view');

Route::match(['get', 'post'], '/testimonials/{id}/edit', '\App\Http\Controllers\Admin\TestimonialsController@edit')
    ->name('admin.testimonials.edit');

Route::post('/testimonials/bulkActions/{action}', '\App\Http\Controllers\Admin\TestimonialsController@bulkActions')
    ->name('admin.testimonials.bulkActions');

Route::get('/testimonials/{id}/delete', '\App\Http\Controllers\Admin\TestimonialsController@delete')
    ->name('admin.testimonials.delete');