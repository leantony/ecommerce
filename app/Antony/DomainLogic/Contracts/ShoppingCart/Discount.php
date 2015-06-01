<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use App\Models\Product;
use Money\Money;

interface Discount
{
    /**
     * Calculate the discount on a Product
     *
     * @param Product
     *
     * @return Money
     */
    public function product(Product $product);

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate();
}
