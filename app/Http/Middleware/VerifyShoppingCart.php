<?php namespace App\Http\Middleware;

use app\Antony\DomainLogic\Modules\ShoppingCart\ShoppingCartEntity;
use Closure;

class VerifyShoppingCart
{
    /**
     * The shopping cart
     *
     * @var ShoppingCartEntity
     */
    private $shoppingCart;

    /**
     * @param ShoppingCartEntity $cart
     */
    public function __construct(ShoppingCartEntity $cart)
    {
        $this->shoppingCart = $cart;
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
        // check if the shopping cart has any items
        if ($this->shoppingCart->hasProducts()) {

            return $next($request);
        }

        return view('frontend.cart.index');
    }

}
