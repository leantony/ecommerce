<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use App\Models\Cart;

trait SessionCache
{

    protected $useCookie = false;

    /**
     * {@inheritdoc}
     */
    public function cacheBasket($basket)
    {

        $this->useCookie ? $this->persistShoppingCart($basket) : $this->session->put('basket', $basket);
    }

    /**
     * {@inheritdoc}
     */
    public function getCachedBasket()
    {
        return $this->useCookie ? $this->getShoppingCart(null) : $this->session->get('basket');
    }

    /**
     * {@inheritdoc}
     */
    public function getCachedProducts()
    {
        return $this->session->get('basket_products');
    }

    /**
     * {@inheritdoc}
     */
    public function emptyCache()
    {

        if ($this->productsAreCached())
            $this->session->pull('basket_products');

        if ($this->basketIsCached())
            $this->session->pull('basket');
    }

    /**
     * {@inheritdoc}
     */
    public function productsAreCached()
    {
        return $this->session->has('basket_products');
    }

    /**
     * {@inheritdoc}
     */
    public function basketIsCached()
    {
        return $this->session->has('basket') or $this->cookie->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function removeCachedProducts()
    {
        $this->session->pull('basket_products');
    }

    /**
     * {@inheritdoc}
     */
    public function cacheProducts($products)
    {
        $this->session->put('basket_products', $products);
    }

    /**
     * {@inheritdoc}
     */
    public function removeCachedBasket()
    {

        $this->session->pull('basket');
    }
}