<?php
Route::post('/actions/uploadFile', '\App\Http\Controllers\Admin\ActionsController@uploadFile')
	    ->name('actions.uploadFile');

Route::post('/actions/removeFile', '\App\Http\Controllers\Admin\ActionsController@removeFile')
	    ->name('actions.removeFile');