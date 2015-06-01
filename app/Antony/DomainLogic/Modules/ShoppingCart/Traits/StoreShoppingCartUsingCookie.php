<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use App\Models\Cart;

trait StoreShoppingCartUsingCookie
{

    /**
     * Creates & queues our shopping cart cookie to be sent with the next response from our application
     */
    public function persistShoppingCart()
    {
        $this->shoppingCartCookie->cookie->queue($this->shoppingCartCookie->name, $this->cart, $this->shoppingCartCookie->timespan);
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
        $this->data = !is_null($attribute) ? $this->shoppingCartCookie->fetch()->get($attribute) : $this->shoppingCartCookie->fetch()->get();

        return $this->data;
    }

    /**
     * Get data from the shopping cart cookie
     *
     * @return array|null
     */
    public function getCookieData()
    {
        $this->data = $this->shoppingCartCookie->fetch()->get();

        return $this->data;
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Cookie
     */
    public function unlinkShoppingCart()
    {
        return $this->shoppingCartCookie->destroy();
    }

}