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
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'App\Http\Middleware\VerifyCsrfToken',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // site (frontend) user authentication
        'auth' => 'App\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',

        // api
        'user.found' => 'App\Http\Middleware\CreateAccountUsingAPIdata',
        'api.authenticate' => 'App\Http\Middleware\AuthenticateWithAPI',

        // for all requests to the backend (Administrative pages)
        'backend-access' => 'App\Http\Middleware\BackendAccess',
        'backend-authorization' => 'App\Http\Middleware\BackendAuthorization',
        'auth.backend' => 'App\Http\Middleware\BackendAuthentication',

        // plain http transmission, or https
        'http' => 'App\Http\Middleware\RemoveSSL',
        'https' => 'App\Http\Middleware\RequireSSL',

        // shopping cart
        'cart.check' => 'App\Http\Middleware\VerifyShoppingCart',

        // checkout
        'checkout.guest' => 'App\Http\Middleware\CheckOutAsGuest',
        'checkout.user' => 'App\Http\Middleware\CheckOutAsAuthUser',

        // prevent the user from reviewing a product twice
        'reviews.check' => 'App\Http\Middleware\preventDoubleReviews',

        // checks if an anonymous user has already sent a contact message
        'msg.check' => 'App\Http\Middleware\AnonymousContactMessages',

        // orders
        'orders.verify' => 'App\Http\Middleware\VerifyOrders',

        // age filter
        'age.filter' => 'App\Http\Middleware\AgeFilter',
    ];

}
