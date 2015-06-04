<?php namespace App\Http\Middleware;

use Closure;

class CheckOutAsAuthUser
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if the user is authenticated
        if (!is_null($request->user())) {

            // check if the user's account information is filled correctly
            if ($request->user()->isRipeForCheckout()) {

                return $next($request);
            } else {

                flash()->overlay("Account data incomplete",
                    "Please access your account and check if your home address/county/town details are set correctly.
                    You need them filled in correctly to checkout."
                );

                return redirect()->back();
            }

        }

        // check if the user had created an account
        if ($request->getSession()->has('account_created_after_checkout') & $request->getSession()->has('after_account_create')) {

            return redirect()->to($request->getSession()->get('after_account_create'));
        }
        return redirect()->guest(route('checkout.auth'), 302, [], true);
    }

}
