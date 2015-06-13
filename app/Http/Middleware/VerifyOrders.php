<?php namespace App\Http\Middleware;

use app\Antony\DomainLogic\Modules\Cookies\OrderCookie;
use Closure;

class VerifyOrders
{

    /**
     * @var OrderCookie
     */
    private $orderCookie;

    /**
     * @param OrderCookie $orderCookie
     */
    public function __construct(OrderCookie $orderCookie)
    {

        $this->orderCookie = $orderCookie;
    }

    /**
     * Checks that a user has made an order. This is used when the user needs to view their invoice after submitting an order
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null($request->user())) {
            if ($this->orderCookie->exists()) {

                if (!empty($this->orderCookie->fetch()->get())) {
                    return $next($request);
                }
            }

            flash()->warning('You need to make an order first to proceed');

            return redirect()->route('checkout.step1');
        }

        return $next($request);
    }

}
