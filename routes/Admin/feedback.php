<?php
Route::get('/feedback', '\App\Http\Controllers\Admin\FeedbackController@index')
    ->name('admin.feedback');

Route::match(['get', 'post'], '/feedback/add', '\App\Http\Controllers\Admin\FeedbackController@add')
    ->name('admin.feedback.add');

Route::get('/feedback/{id}/view', '\App\Http\Controllers\Admin\FeedbackController@view')
    ->name('admin.feedback.view');

Route::match(['get', 'post'], '/feedback/{id}/edit', '\App\Http\Controllers\Admin\FeedbackController@edit')
    ->name('admin.feedback.edit');

Route::post('/feedback/bulkActions/{action}', '\App\Http\Controllers\Admin\FeedbackController@bulkActions')
    ->name('admin.feedback.bulkActions');

Route::get('/feedback/{id}/delete', '\App\Http\Controllers\Admin\FeedbackController@delete')
    ->name('admin.feedback.delete');