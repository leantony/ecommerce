<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

interface ShoppingCartCache
{

    /**
     * Stores the basket in the user's shopping cart
     *
     * @param $basket
     *
     * @return void
     */
    public function cacheBasket($basket);

    /**
     * Returns the cached shopping cart
     *
     * @return Cart|null
     */
    public function getCachedBasket();

    /**
     * Returns the products stored in session
     *
     * @return Collection|null
     */
    public function getCachedProducts();

    /**
     * Removes both the basket and the products in it, from the current session
     *
     * @return void
     */
    public function emptyCache();

    /**
     * Checks is any products have been cached in the user's session
     *
     * @return boolean
     */
    public function productsAreCached();

    /**
     * Check if a basket or shopping cart is cached
     *
     * @return boolean
     */
    public function basketIsCached();

    /**
     * Removes products cached in the session
     *
     * @return void
     */
    public function removeCachedProducts();

    /**
     * Stores products in the basket in the usr's session
     *
     * @param $products
     *
     * @return void
     */
    public function cacheProducts($products);

    /**
     * Removes the cached basket from the session
     *
     * @return void
     */
    public function removeCachedBasket();
}