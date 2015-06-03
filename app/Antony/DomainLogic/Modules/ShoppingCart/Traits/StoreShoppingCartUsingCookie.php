<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use App\Models\Cart;

trait StoreShoppingCartUsingCookie
{

    /**
     * Creates & queues our shopping cart cookie to be sent with the next response from our application
     */
    public function persistShoppingCart($cart)
    {
        $this->cookie->cookie->queue($this->cookie->name, $cart, $this->cookie->timespan);
    }

    /**
     * Get data from the shopping cart cookie. If a null attribute is
     * provided, we just return the whole cart object
     *
     * @param string $attribute
     *
     * @return Cart|int|null
     */
    public function getShoppingCart($attribute = 'id')
    {
        return !is_null($attribute) ? $this->cookie->fetch()->get($attribute) : $this->cookie->fetch()->get();

    }

    /**
     * Get data from the shopping cart cookie
     *
     * @return array|null
     */
    public function getCookieData()
    {
        return $this->cookie->fetch()->get();
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Cookie
     */
    public function unlinkShoppingCart()
    {
        return $this->cookie->destroy();
    }

}