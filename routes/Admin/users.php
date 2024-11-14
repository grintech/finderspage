<?php

Route::get('/users', '\App\Http\Controllers\Admin\UsersController@index')

    ->name('user.users');



Route::get('/users/add', '\App\Http\Controllers\Admin\UsersController@add')

    ->name('user.users.add');



Route::post('/users/add', '\App\Http\Controllers\Admin\UsersController@add')

    ->name('user.users.add');



Route::get('/users/{id}/view', '\App\Http\Controllers\Admin\UsersController@view')

    ->name('user.users.view');    



Route::get('/users/{id}/edit', '\App\Http\Controllers\Admin\UsersController@edit')

    ->name('user.users.edit');



Route::post('/users/{id}/edit', '\App\Http\Controllers\Admin\UsersController@edit')

    ->name('user.users.edit');



Route::post('/users/{id}/edit', '\App\Http\Controllers\Admin\UsersController@edit')

    ->name('user.actions.switchUpdate');

Route::post('/users/status/{id}', '\App\Http\Controllers\Admin\UsersController@updateUserStatus')

    ->name('user.switchUpdate');     



Route::post('/users/bulkActions/{action}', '\App\Http\Controllers\Admin\UsersController@bulkActions')

    ->name('user.users.bulkActions');



Route::get('/users/{id}/delete', '\App\Http\Controllers\Admin\UsersController@delete')

    ->name('user.users.delete');


Route::get('/users/delete/permanent/{id}', '\App\Http\Controllers\Admin\UsersController@permanent_delete')

    ->name('user.users.permanent.delete');



Route::post('/users/ban', '\App\Http\Controllers\Admin\UsersController@updatebanstatus')

    ->name('user.ban');