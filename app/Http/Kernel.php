<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // site (frontend) user authentication
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // api
        'user.found' => \App\Http\Middleware\CreateAccountUsingAPIdata::class,
        'api.authenticate' => \App\Http\Middleware\AuthenticateWithAPI::class,

        // for all requests to the backend (Administrative pages)
        'backend-access' => \App\Http\Middleware\BackendAccess::class,
        'backend-authorization' => \App\Http\Middleware\BackendAuthorization::class,
        'auth.backend' => \App\Http\Middleware\BackendAuthentication::class,

        // plain http transmission, or https
        'http' => \App\Http\Middleware\RemoveSSL::class,
        'https' => \App\Http\Middleware\RequireSSL::class,

        // shopping cart
        'cart.check' => \App\Http\Middleware\VerifyShoppingCart::class,

        // checkout
        'checkout.guest' => \App\Http\Middleware\CheckOutAsGuest::class,
        'checkout.user' => \App\Http\Middleware\CheckOutAsAuthUser::class,

        // prevent the user from reviewing a product twice
        'reviews.check' => \App\Http\Middleware\preventDoubleReviews::class,

        // checks if an anonymous user has already sent a contact message
        'msg.check' => \App\Http\Middleware\AnonymousContactMessages::class,

        // orders
        'orders.verify' => \App\Http\Middleware\VerifyOrders::class,

        // age filter
        'age.filter' => \App\Http\Middleware\AgeFilter::class,
    ];

}
