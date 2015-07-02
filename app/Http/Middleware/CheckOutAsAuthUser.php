<?php namespace App\Http\Middleware;

use Closure;

class CheckOutAsAuthUser
{

    /**
     * This middleware allows the user to checkout as an authenticated user
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

            // check if the user's account information is filled correctly. A user's account information should be
            // correctly set, to prevent any data inconsistency errors ahead
            if ($request->user()->isRipeForCheckout()) {

                return $next($request);
            } else {

                flash()->overlay(
                    "Please access your account and check if your home address/county/town details are set correctly.
                    You need them filled in correctly before you checkout.", "Account data incomplete"
                );

                return redirect()->back();
            }

        }

        // This part checks if the user had earlier created an account during checkout.
        // then, it will redirect the new user to the new url
        if ($request->getSession()->has('account_created_after_checkout') & $request->getSession()->has('after_account_create')) {

            return redirect()->to($request->session()->get('after_account_create'));
        }
        return redirect()->guest(route('checkout.auth'), 302, [], true);
    }

}
