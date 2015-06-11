<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use App\Models\Cart;

trait SessionCache
{

    /**
     * Stores the basket in the user's shopping cart
     *
     * @param $basket
     *
     * @return void
     */
    public function cacheBasket($basket)
    {

        $this->session->put('basket', $basket);
    }

    /**
     * Returns the cached shopping cart
     *
     * @return Cart|null
     */
    public function getCachedBasket()
    {
        return $this->session->get('basket');
    }

    /**
     * Returns the products stored in session
     *
     * @return Collection|null
     */
    public function getCachedProducts()
    {
        return $this->session->get('basket_products');
    }

    /**
     * Removes both the basket and the products in it, from the current session
     *
     * @return void
     */
    public function emptyCache()
    {

        if ($this->productsAreCached()) $this->session->pull('basket_products');

        if ($this->basketIsCached()) $this->session->pull('basket');
    }

    /**
     * Checks is any products have been cached in the user's session
     *
     * @return boolean
     */
    public function productsAreCached()
    {
        return $this->session->has('basket_products');
    }

    /**
     * Check if a basket or shopping cart is cached
     *
     * @return boolean
     */
    public function basketIsCached()
    {
        return $this->session->has('basket');
    }

    /**
     * Removes products cached in the session
     *
     * @return void
     */
    public function removeCachedProducts()
    {
        $this->session->pull('basket_products');
    }

    /**
     * Stores products in the basket in the usr's session
     *
     * @param $products
     *
     * @return void
     */
    public function cacheProducts($products)
    {
        $this->session->put('basket_products', $products);
    }

    /**
     * Removes the cached basket from the session
     *
     * @return void
     */
    public function removeCachedBasket()
    {

        $this->session->pull('basket');
    }
}