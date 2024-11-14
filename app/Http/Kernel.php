<?php

namespace App\Http;



use Illuminate\Foundation\Http\Kernel as HttpKernel;



class Kernel extends HttpKernel

{

    /**

     * The application's global HTTP middleware stack.

     *

     * These middleware are run during every request to your application.

     *

     * @var array

     */

    protected $middleware = [

        // \App\Http\Middleware\TrustHosts::class,

        \App\Http\Middleware\TrustProxies::class,

        \Fruitcake\Cors\HandleCors::class,

        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        \App\Http\Middleware\TrimStrings::class,

        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        \Fruitcake\Cors\HandleCors::class,
        

    ];



    /**

     * The application's route middleware groups.

     *

     * @var array

     */

    protected $middlewareGroups = [

        'web' => [

            \App\Http\Middleware\EncryptCookies::class,

            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            \Illuminate\Session\Middleware\StartSession::class,

            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            \App\Http\Middleware\VerifyCsrfToken::class,

            // \Illuminate\Routing\Middleware\SubstituteBindings::class,

             \App\Http\Middleware\RecordPostView::class,

        ],

       

        'api' => [

            // 'throttle:api',

            // \Illuminate\Routing\Middleware\SubstituteBindings::class.':5,15',

        ],




    ];



    /**

     * The application's route middleware.

     *

     * These middleware may be assigned to groups or used individually.

     *

     * @var array

     */

    protected $routeMiddleware = [

        'adminAuth' => \App\Http\Middleware\AdminAuth::class,

        'apiAuth' => \App\Http\Middleware\ApiAuth::class,

        'guest' => \App\Http\Middleware\Guest::class,

        'auth' => \App\Http\Middleware\Authenticate::class,

        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // 'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':5,15', // 5 attempts every 15 minutes

        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'xss' => \App\Http\Middleware\XSS::class,

        'record_post_view' => \App\Http\Middleware\GetBlogViews::class,

        'get_listing_view' => \App\Http\Middleware\GetListingViews::class,

        'checkAvailable' => \App\Http\Middleware\CheckAvailableStatus::class,

        'update_outdated_post' => \App\Http\Middleware\update_outdated_post::class,

        'update_outdated_entertainment_post' => \App\Http\Middleware\update_outdated_entertainment_post::class,

    ];

}

