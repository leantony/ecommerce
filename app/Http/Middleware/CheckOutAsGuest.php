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
     * Handle an incoming request.
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

            // check for required params
            if ($request->get('allow') === "1" & empty($this->guest->getCookieData())) {

                return $next($request);
            }

            if ($this->guest->isAGuest()) {
                return $next($request);
            }
            return redirect()->guest(route('checkout.auth'));
        }

        return redirect()->route('u.checkout.step2');
    }

}
