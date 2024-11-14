<?php
Route::get('/notification', '\App\Http\Controllers\Admin\NotificationController@index')
    ->name('admin.notification');


Route::post('/notification/mark-as-read/{id}', '\App\Http\Controllers\Admin\NotificationController@markAsRead')
    ->name('markAsRead');
//Route::post('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('markAsRead');