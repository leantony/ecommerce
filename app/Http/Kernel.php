<?php namespace App\Http;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        Middleware\EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // site (frontend) user authentication
        'auth' => Middleware\Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest' => Middleware\RedirectIfAuthenticated::class,

        // api
        'user.found' => Middleware\CreateAccountUsingAPIdata::class,
        'api.authenticate' => Middleware\AuthenticateWithAPI::class,

        // for all requests to the backend (Administrative pages)
        'backend-access' => Middleware\BackendAccess::class,
        'backend-authorization' => Middleware\BackendAuthorization::class,
        'auth.backend' => Middleware\BackendAuthentication::class,

        // plain http transmission, or https
        'http' => Middleware\RemoveSSL::class,
        'https' => Middleware\RequireSSL::class,

        // shopping cart
        'cart.check' => Middleware\VerifyShoppingCart::class,

        // checkout
        'checkout.guest' => Middleware\CheckOutAsGuest::class,
        'checkout.user' => Middleware\CheckOutAsAuthUser::class,

        // prevent the user from reviewing a product twice
        'reviews.check' => Middleware\preventDoubleReviews::class,

        // checks if an anonymous user has already sent a contact message
        'msg.check' => Middleware\AnonymousContactMessages::class,

        // orders
        'orders.verify' => Middleware\VerifyOrders::class,

        // age filter
        'age.filter' => Middleware\AgeFilter::class,
    ];

}
