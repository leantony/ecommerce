<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use Illuminate\Support\Collection;
use App\Models\Cart;

/**
 * Implementing a caching mechanism will improve cart performance, by mitigating
 * the process of querying and requerying a basket, even when it has not been updated
 *
 * It also keeps the cart data between requests, hence mitigating the issue of query duplicates
 * The data cached include the actual basket object, and products in this basket
 *
 */
interface ShoppingCartCache
{

    /**
     * Stores the basket in the cache
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
     * Returns the products stored in cache
     *
     * @return Collection|null
     */
    public function getCachedProducts();

    /**
     * This empties the cache, by removing both the basket and products
     *
     * @return void
     */
    public function emptyCache();

    /**
     * Checks is any products have been cached
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
     * Removes all cached products
     *
     * @return void
     */
    public function removeCachedProducts();

    /**
     * Stores products in the basket in the cache
     *
     * @param $products
     *
     * @return void
     */
    public function cacheProducts($products);

    /**
     * Removes the cached basket from the cache
     *
     * @return void
     */
    public function removeCachedBasket();
}