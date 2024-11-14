<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\PayPalPaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('login-app', [AuthController::class, 'loginAPI'])->withoutMiddleware(['throttle:api']);
Route::post('/signup-app', [AuthController::class, 'signupAPI']);



Route::post('paypal/subscription_code/{planname}', [PayPalPaymentController::class, 'SubscriptionCode'])->name('paypal.subscription_code');