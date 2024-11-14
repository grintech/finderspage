<?php
use Illuminate\Support\Facades\Route;
// Route::middleware('throttle')->group(function () {
//   Route::post('/login', '\App\Http\Controllers\Frontend\AuthController@login')
//     ->name('auth.login');
// });


Route::get('/login', '\App\Http\Controllers\Frontend\AuthController@login')
    ->name('auth.login');

Route::post('/login', '\App\Http\Controllers\Frontend\AuthController@login')
    ->name('auth.login');

Route::post('/switch-account', '\App\Http\Controllers\Frontend\AuthController@switchAccount')
    ->name('auth.login.switch');

Route::post('/session-destroy', '\App\Http\Controllers\Frontend\AuthController@sessionDestory')
    ->name('session.destroy');

Route::get('/signup', '\App\Http\Controllers\Frontend\AuthController@signup')->name('auth.signupuser');

Route::post('/usersignupfront', '\App\Http\Controllers\Frontend\AuthController@signup');

Route::get('/auth/validate-email', '\App\Http\Controllers\Frontend\AuthController@validateEmail')
    ->name('auth.validateEmail');

Route::get('/email-verification/{hash}', '\App\Http\Controllers\Frontend\AuthController@emailVerification')
    ->name('auth.emailVerification');

Route::get('/auth/success', '\App\Http\Controllers\Frontend\AuthController@success')
    ->name('auth.success');
    

// Route::get('/business-registration/{token}/{id}', '\App\Http\Controllers\Frontend\AuthController@businessRegistration')
//     ->name('auth.businessRegistration');

// Route::post('/business-registration/{token}/{id}', '\App\Http\Controllers\Frontend\AuthController@businessRegistration')
//     ->name('auth.businessRegistration');

Route::get('/auth/logout', '\App\Http\Controllers\Frontend\AuthController@logout')
    ->name('auth.logout');
Route::get('/checking', '\App\Http\Controllers\Frontend\AuthController@notification');

// Route::get('/forget/password', '\App\Http\Controllers\Frontend\AuthController@forgotPassword')->name('forgotPassword');

Route::get('/user/forgot-password', '\App\Http\Controllers\Frontend\AuthController@forgotPassword')

    ->name('user.forgotPassword');


Route::post('/user/forgot-password', '\App\Http\Controllers\Frontend\AuthController@forgotPassword')

    ->name('user.forgotPassword');



Route::get('/user/recover-password/{hash}', '\App\Http\Controllers\Frontend\AuthController@recoverPassword')

    ->name('user.recoverPassword');



Route::post('/user/recover-password/{hash}', '\App\Http\Controllers\Frontend\AuthController@recoverPassword')

    ->name('user.recoverPassword');

Route::get('auth/instagram', [\App\Http\Controllers\Frontend\AuthController::class, 'redirectToInstagram'])->name('auth.instagram');

Route::get('auth/instagram/callback', [\App\Http\Controllers\Frontend\AuthController::class, 'handleInstagramCallback']);


Route::get('auth/facebook', [\App\Http\Controllers\Frontend\AuthController::class, 'redirectToProvider'])->name('auth.facebook');

Route::get('auth/facebook/callback', [\App\Http\Controllers\Frontend\AuthController::class, 'handleProviderCallback']);


Route::get('auth/google', [\App\Http\Controllers\Frontend\AuthController::class, 'redirectToGoogle'])->name('auth.google');

Route::get('auth/google/callback', [\App\Http\Controllers\Frontend\AuthController::class, 'handleGoogleCallback']);

Route::post('user-block', [\App\Http\Controllers\Frontend\AuthController::class, 'blockUser']);

Route::post('user-block-get-blockby', [\App\Http\Controllers\Frontend\AuthController::class, 'blockget_block_by']);
Route::post('user-block-get-blockid', [\App\Http\Controllers\Frontend\AuthController::class, 'blockget_block_id']);

Route::post('blockgetUser', [\App\Http\Controllers\Frontend\AuthController::class, 'blockgetUser']);

Route::post('unblock-User', [\App\Http\Controllers\Frontend\AuthController::class, 'UnblockUser']);


Route::post('sendOTP', [\App\Http\Controllers\Frontend\AuthController::class, 'sendOTP'])->name('send.otp');

Route::post('remove/users', [\App\Http\Controllers\Frontend\AuthController::class, 'Remove_Switch_Account'])->name('Remove.Switch.Account');


//bulk delete message //
Route::post('Bulk-delete', [\App\Http\Controllers\Frontend\AuthController::class, 'bulkDeleteMessage'])->name('Bulk_Delete_message');


