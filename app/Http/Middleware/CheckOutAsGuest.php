<?php namespace App\Http\Middleware;

use app\Antony\DomainLogic\Modules\Checkout\Guest\GuestBillingAddress;
use Closure;

class CheckOutAsGuest
{

    /**
     * @var GuestBillingAddress
     */
    private $guest;

    /**
     * @param GuestBillingAddress $guest
     */
    public function __construct(GuestBillingAddress $guest)
    {
        $this->guest = $guest;
    }

    /**
     * This middleware checks that a guest user is indeed checking out
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // only non-authenticated users should be allowed to checkout as guests
        if (is_null($request->user())) {

            // For a successful guest checkout to be initialized, we pass in an allow=1 param into the url
            // This is because later, the checkout cookie will be used to verify that the user is a guest, and for now
            // it does not exist until the user fills in the guest user details form
            if ($request->get('allow') === "1" & empty($this->guest->getCookieData())) {

                return $next($request);
            }

            // by the time this statement is executed, the cookie exists, so we do the normal check
            if ($this->guest->isAGuest()) {
                return $next($request);
            }
            return redirect()->guest(route('checkout.auth'));
        }

        // if the user is authenticated, then we skip step1 of checkout, which is filling in guest data
        return redirect()->route('u.checkout.step2');
    }

}
