<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

trait StoreShoppingCartUsingSession
{
    /**
     * Get data from the shopping cart cookie
     *
     * @param string $attribute
     *
     * @return mixed
     */
    public function getShoppingCart($attribute = 'id')
    {
        $this->data = !is_null($attribute) ? session('shopping_cart')->$attribute : session('shopping_cart');

        return $this->data;
    }

    /**
     * Stores the shopping cart in the user's session
     */
    public function persistShoppingCart()
    {
        session(['shopping_cart' => $this->cart]);
    }

    /**
     * Removes a shopping cart from the current session
     */
    public function unlinkShoppingCart()
    {
        \Session::forget('shopping_cart');
    }
}